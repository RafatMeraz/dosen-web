<?php

namespace App\Console\Commands;

use PDF;
use Carbon\Carbon;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ShopVisitReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:visit_report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shop visits report';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        $date = Carbon::now()->format('F, Y');

        $users = User::where('role', 'user')->get();

        $division_id = 1;
        $shops = Shop::select('id', 'name', 'address')->where('division_id', $division_id)->get();

        $allData = [];

        foreach ($users as $key => $user) {
            $dataSet = [];
            foreach ($shops as $shop) {
                $counter =  DB::table('visits')
                    ->join('shops', 'visits.shop_id', 'shops.id')
                    ->select('visits.*', 'shops.division_id as shop_division_id')
                    ->where('visits.user_id', '=', $user->id)
                    ->where('visits.shop_id', '=', $shop->id)
                    ->whereMonth('visits.created_at', '=', $month)
                    ->whereYear('visits.created_at', '=', $year)
                    ->where('shops.division_id', '=',  $user->division_id)
                    ->count();

                $dataSet[] = [
                    $shop->name,
                    $counter,
                ];
            }

            $allData[] = [
                'user' => $user,
                'dataSet' => $dataSet,
            ];
        }

        $pdf = PDF::loadView('bar-chart', compact('allData','date'));

        $title = ''.Carbon::now()->format('F').'_'.Carbon::now()->format('Y').'';

        $content = $pdf->download()->getOriginalContent();
        Storage::put('public/pdf/shop_visits_'.$title.'.pdf',$content);

        $file_link = url('/') . '/storage/pdf/shop_visits_'.$title.'.pdf';

        $mailData['email'] = 'shamirabdin@gmail.com';
        $mailData['file'] = $file_link;
        $mailData['date'] = $date;
        $mailData['title'] = 'Monthly report for Dosen Visits - '.$date;

        Mail::send('emails.shop-visit-report', $mailData, function ($message) use ($mailData) {
            $message->to($mailData['email'])
                ->subject($mailData['title']);
        });

        $this->info('success');
    }
}
