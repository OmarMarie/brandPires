
@if(isset($bulk))
    <form action="{{ route('bulks.update', [app()->getLocale(),$bulk]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('bulks.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name"
                               @if(isset($bulk)) value="{{ $bulk->name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Cost</label>
                        <input type="number" class="form-control" name="cost" placeholder="Cost"
                               @if(isset($bulk)) value="{{ $bulk->cost }}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Number Of Bubbles</label>
                        <input type="text" class="form-control" name="number_of_bubbles" placeholder="Number Of Bubbles"
                               @if(isset($bulk)) value="{{ $bulk->number_of_bubbles}}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Bonus</label>
                        <input type="text" class="form-control" name="bonus" placeholder="Bonus"
                               @if(isset($bulk)) value="{{ $bulk->bonus}}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Duration</label>
                        <input type="text" class="form-control" name="duration" placeholder="Duration"
                               @if(isset($bulk)) value="{{ $bulk->duration}}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Top Up Cost</label>
                        <input type="text" class="form-control" name="top_up_cost" placeholder="Top Up Cost"
                               @if(isset($bulk)) value="{{ $bulk->top_up_cost}}" @endif>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Average Players</label>
                        <input type="text" class="form-control" name="average_players" placeholder="Average Players"
                               @if(isset($bulk)) value="{{ $bulk->average_players}}" @endif>
                    </div>

                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-dark" style="float: right">
                    </div>
                </div>
            </form>
