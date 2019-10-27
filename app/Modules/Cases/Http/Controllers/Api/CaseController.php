<?php

namespace App\Modules\Cases\Http\Controllers\Api;

use App\Modules\Cases\Dto\CaseData;
use App\Modules\Cases\Models\Cases;
use App\Modules\Cases\Models\Statistic;
use App\Modules\Cases\Models\Word;
use App\Modules\Cases\Presenters\WordPresenter;
use App\Modules\Cases\Requests\CaseRequest;
use App\Http\Controllers\Controller;
use App\Modules\Cases\Requests\ShowRequest;
use App\Modules\Cases\Services\CaseService;
use App\Modules\Users\Models\User;
use Carbon\Carbon;
use Hemp\Presenter\Presenter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CaseController
 * @package App\Modules\Cases\Http\Controllers\Api
 */
class CaseController extends Controller
{
    /**
     * @var CaseService
     */
    protected $caseService;

    /**
     * CaseController constructor.
     * @param CaseService $caseService
     */
    public function __construct(CaseService $caseService)
    {
        $this->caseService = $caseService;
    }

    /**
     * @param ShowRequest $request
     * @return JsonResponse
     */
    public function index(ShowRequest $request): JsonResponse
    {
        $query = Word::with('cases')->with('statistic');

        if ($request->date != null) {
            $date = $request->date;
            $date = Carbon::createFromDate($request->date);
            $query = $query->whereHas('statistic', function ($subQuery) use ($date) {
                $subQuery->whereBetween('statistic.created_at', [$date->startOfDay()->format('Y-m-d H:i:s'),
                    $date->endOfDay()->format('Y-m-d H:i:s')]);
            });
        }

        if ($request->ip != null) {
            $ip = $request->ip;
            $query = $query->whereHas('statistic', function ($subQuery) use ($ip) {
                $subQuery->where('statistic.ip', $ip);
            });
        }

        $words = $query->get();
        $wordPresenter = Presenter::collection($words, WordPresenter::class);
        return response()->json($wordPresenter, 200);
    }

    /**
     * @param CaseRequest $request
     * @return JsonResponse
     * @throws \Spatie\DataTransferObject\DataTransferObjectError
     */
    public function getCases(CaseRequest $request): JsonResponse
    {
        $caseData = new CaseData($request->only(['word', 'gender', 'is_enthusiastic']));
        $caseData->word = mb_strtolower($caseData->word);
        $word = Word::where('word', $caseData->word)->first();
        $code = 422;

        if ($word instanceof Word) {
            $cases = Cases::where('word_id', $word->id)->pluck('case');
            $code = 200;
        } else {
            $caseData->declension = $this->caseService->getDeclension($caseData);
            $cases = $this->caseService->transform($caseData);

            if (isset($cases['error']) || count($cases) != 6) {
                return response()->json($cases, $code);
            }

            $word = Word::create(['word' => $cases[0]]);

            if (!$word instanceof Word) {
                return response()->json(['error' => __('cases::case.cant_transform')], $code);
            }

            $data = [];
            foreach ($cases as $key => $case) {
                $data[] = [
                    'word_id' => $word->id,
                    'case_id' => $key+1,
                    'case' => $case
                ];
            }

            Cases::insert($data);
            $code = 201;
        }

        $user = User::firstOrCreate(['email' => $request->email],[
            'email' => $request->email,
            'name' => $request->email,
            'password' => bcrypt('11111')
        ]);

        Statistic::create(['user_id' => $user->id, 'word_id' => $word->id, 'ip' => Request::ip()]);

        return response()->json($cases, $code);
    }

    /**
     * @return JsonResponse
     */
    public function top(): JsonResponse
    {
        $date = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $statistic = Statistic::select(DB::raw('users.email, user_id, COUNT(word_id) as count'))
            ->leftJoin('users', 'users.id', '=', 'statistic.user_id')
            ->where('statistic.created_at', '>', $date)
            ->groupBy('user_id')
            ->having('count', '>', 3)
            ->orderBy('count', 'DESC')->limit(10)->get();
        return response()->json($statistic, 200);
    }
}
