<?php
namespace App\Http\Models\Logics;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\LogicDbTrait;

class BoatCommentLogic
{
    use LogicDbTrait;

    /**
     * Get list comment of a boat
     *
     * @param integer $boatId
     * @param integer $userId
     * @param integer $charterId
     * @return {object}
     */
    public function getCommentOnBoat($boatId, $userId = null, $charterId = null)
    {
        $result = $this->getCommentOnBoats([$boatId], $userId, $charterId);

        return isset($result[$boatId]) ? $result[$boatId] : null;
    }

    /**
     * Get list comment using a list of boat ids
     *
     * @param array $boatIds
     * @param integer $userId
     * @param integer $charterId
     * @return array[\Illuminate\Support\Collection] 
     */
    public function getCommentOnBoats(array $boatIds, $userId = null, $charterId = null)
    {
        $sql = DB::table('boat_comment')
            ->select(
                'comment_title',
                'boat_id',
                'boat_comment.add_date',
                'comment',
                'comment_from',
                'rate',
                'invoice',
                'name'
            )
            ->join('boat_user', 'boat_user.user_id', '=', 'boat_comment.comment_from')
            ->whereIn('boat_id', $boatIds)->where('status','=', 'y');
        
        if ($userId) {
            $sql = $sql->where('comment_from', '=', $userId);
        }

        if ($charterId) {
            $sql = $sql->where('invoice', '=', $charterId);
        }
        $sql = $sql->orderBy('comment_id', 'DESC');
        $result = $sql->get();

        return $result->groupBy('boat_id');
    }

    /**
     * Insert new comment
     *
     * @param integer $boatId
     * @param array   $data
     * @return void
     */
    public function insertComment($data)
    {
        DB::table('boat_comment')->insert($data);
    }

    public function getNotComment()
    {
        $notComment = DB::table('boat_charter_book')->where('ratingyes', '=', 0)->where('user_id', '=', Auth::id());

        return $notComment->count();
        // if($notcomment>0){
        //  $_SESSION["msg"]='<h4>Welcome</h4><br>'.$general_func->SINGLECOMMENTRATE(5).'</br></br>You seem to have forgotten to rate some of your booking, please  <a href=boat-bookings.php> Click Here</a> to provide your feedback and rating.';
             
        // }
    }
}