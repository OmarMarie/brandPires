<?php

namespace App\Console\Commands;

use App\Models\Bubbles;
use App\Models\Campaign;
use App\Models\GiftAction;
use App\Models\PlayerBubbles;
use Illuminate\Console\Command;

class BubbleExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bubble:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the bubble is expired for every user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * Get all players that had captured bubbles and save it into variable $playerBubbles;
     * Foreach to all players every minute to check if the bubble in tank is expired or not
     * If now(Date of today) is greater than the created_at date then it should be expired
     * Check if the campaign is available to return the bubble to sky or make it expired.
     * Check if the bubble has a gift if so then -> change the action to 0 - expired
     * Finally make the player bubble status to 2 - expired.
     * @return mixed
     */
    public function handle()
    {
        $playersBubbles = PlayerBubbles::with('bubbles:id,duration,available,campaign_id,bubble_type')->get();

        foreach ($playersBubbles as $playersBubble) {
            $expireDate = date('Y-m-d H:i:s', strtotime('+'.$playersBubble->bubbles->duration.' hours', strtotime($playersBubble->created_at)));

            if (now() > $expireDate)
            {
                $campaignAvailable = Campaign::where('id', $playersBubble->bubbles->campaign_id)->value('available');
                if ($campaignAvailable == 1){// if campaign available
                    Bubbles::where('id', $playersBubble->bubbles->id)->update([
                        'available' => 1
                    ]);
                } else {
                    Bubbles::where('id', $playersBubble->bubbles->id)->update([
                        'available' => 0,
                        'status' => 2
                    ]);
                }

                if ($playersBubble->bubbles->bubble_type == 1){
                    GiftAction::where('player_id', $playersBubble->player_id)->where('bubble_id', $playersBubble->bubble_id)->update([
                        'action' => 0
                    ]);
                }

                PlayerBubbles::where('id', $playersBubble->id)->update([
                    'status' => 2
                ]);
            }
        }
        \Log::info("Done!");
    }
}
