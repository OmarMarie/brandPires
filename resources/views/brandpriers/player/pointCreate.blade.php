<form action="{{ route('pointsUpdate', [app()->getLocale()]) }}" method="POST" id="userForm">
    @csrf
    <div class="row">
        <input type="hidden" value="{{$player->id}}" name="player_id">
        <div class="col-md-12 form-group">
            <label>Player Level Point: <span class="font-weight-bold text-warning" > {{$player->lvl_pts}}</span></label>
        </div>
        <div class="col-md-6 form-group">
            <label>Point Add</label>
            <input type="text" class="form-control" name="point_add" placeholder="Point Add">
        </div>
        <div class="col-md-12 form-group">
            <input type="submit" value="Submit" class="btn btn-dark" style="float: right">
        </div>
    </div>
</form>

