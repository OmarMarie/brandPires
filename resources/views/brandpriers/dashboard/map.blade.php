<style>
    .sub_titel {
        background: whitesmoke;
        font-weight: normal;
        color: #000;
        width: max-content;
        font-size: 12px;
    }
</style>
<div class="row animate__animated animate__fadeInLeftBig  " style="font-size: 16px; padding:10px 20px; width: 450px;     text-align: left; ">
    @if(count($campaigns)>1)
        <div class="col-md-4 form-group">
            <div class="shadow rounded sub_titel" style="width: 150px;">
                <i class="fas fa-volleyball-ball icon-sm" style="color: #15aabf; padding: 0px 5px"></i> Totale Campaign
                :
                <span style="font-weight: bold;"> {{count($campaigns)}} </span></div>
        </div>
    @endif
    @foreach($campaigns as $campaign)
        <div class="col-md-12 form-group ">
            <div class="" style="font-weight: bold; font-size: 12px; text-align: left;"> Name :  {{$campaign->name}} </div>
        </div>
        <div class="col-md-6 form-group ">
            <div class="sub_titel shadow rounded">
                <i class="fas fa-sort-amount-up" style="color: #15aabf; padding: 0px 5px; font-size: large"></i> Count Bubbles :
                <span
                        style="font-weight: bold;"> {{$campaign->count_bubbles}}</span>
            </div>
        </div>
        <div class="col-md-6 form-group ">
            <div class="sub_titel shadow rounded">
                <i class="fas fa-sort-amount-down" style="color: #15aabf; padding: 0px 5px; font-size: large"></i> Count Bubbles
                Hooked :
                <span
                        style="font-weight: bold;"> {{$campaign->count_bubbles_hooked}}</span>
            </div>
        </div>
        <div class="col-md-6 form-group ">
            <div class="sub_titel shadow rounded">
                <i class="fas fa-sort-amount-up" style="color: #15aabf; padding: 0px 5px; font-size: large"></i> Count Bubbles
                Not Hooked :
                <span
                        style="font-weight: bold;"> {{$campaign->count_bubbles_not_hooked}}</span>
            </div>
        </div>
    @endforeach
    {{--<div class="col-md-4 form-group ">
        <div class="sub_titel shadow rounded" style="background:whitesmoke; font-weight:normal; color: #000">
            <i class="fas fa-child" style="color: #f9b32f; padding: 0px 5px; font-size: large"></i> Under 18 : <span
                    style="font-weight: bold;"> {{$ageUnder18}}</span>
        </div>
    </div>
    <div class="col-md-4 form-group ">
        <div class="sub_titel shadow rounded" style="background:whitesmoke; font-weight:normal; color: #000">
            <i class="fas fa-male" style="color: #f9b32f; padding: 0px 5px; font-size: large"></i> Between 19 - 35 : <span
                    style="font-weight: bold;"> {{$ageBetween19to35}}</span>
        </div>
    </div>
    <div class="col-md-4 form-group ">
        <div class="sub_titel shadow rounded" style="background:whitesmoke; font-weight:normal; color: #000">
            <i class="fas fa-male" style="color: #f9b32f; padding: 0px 5px; font-size: large"></i> Above 35 : <span
                    style="font-weight: bold;"> {{$ageAbove35}}</span>
        </div>
    </div>--}}
</div>