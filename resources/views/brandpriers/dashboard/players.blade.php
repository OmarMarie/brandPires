<div class="row animate__animated animate__fadeInLeftBig animate__slow " style="font-size: 16px;">
    <div class="col-md-4 form-group">
        <div class="shadow rounded sub_titel" style="background:whitesmoke; font-weight:normal; color: #000">
            <i class="fas fa-users icon-sm" style="color: #15aabf; padding: 0px 5px"></i> Totale :
            <span style="font-weight: bold;"> {{$playersCount}} </span></div>
    </div>
    <div class="col-md-4 form-group">
        <div class="shadow rounded sub_titel" style="background:whitesmoke; font-weight:normal; color: #000">
            <i class="fas fa-circle" style="color: #82c91e; padding: 0px 5px"></i> Active Now :
            <span style="font-weight: bold;"> {{$active_now}} </span></div>
    </div>

    <div class="col-md-12 form-group ">
        <div class="" style="font-weight: bold; font-size: 20px"> Gender</div>
    </div>

    <div class="col-md-4 form-group ">
        <div class="sub_titel shadow rounded" style="background:whitesmoke; font-weight:normal; color: #000">
            <i class="fas fa-male" style="color: #15aabf; padding: 0px 5px; font-size: large"></i> Male : <span
                    style="font-weight: bold;"> {{$male}}</span>
        </div>
    </div>

    <div class="col-md-4 form-group ">
        <div class="sub_titel shadow rounded" style="background:whitesmoke; font-weight:normal; color: #000">
            <i class="fas fa-female" style="color: #f783ac; padding: 0px 5px; font-size: large">
            </i> Female : <span style="font-weight: bold;"> {{$female}}</span></div>
    </div>


    <div class="col-md-12 form-group ">
        <div class="" style="font-weight: bold; font-size: 20px"> Average age</div>
    </div>

    <div class="col-md-4 form-group ">
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
    </div>
</div>