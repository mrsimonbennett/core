<div class="ibox-content  p-xl m-t-none">
    <input type="checkbox" id="acceptingApplications" class="js-switcher small"
           @if($property->accepting_applications)checked @endif/> <strong>Accepting
        applications
    </strong>

    <div id="accepting-applications" @if(!$property->accepting_applications) style="display: none;" @endif>
        <p> Share this link with people you would like to submit an application.
        </p>

        <p>

        <div class="row form-group">

            <div class="col-sm-6">
                <input type="text" value="https://{{$company->getFullDomain()}}/a/{{$property->id}}" class="form-control">
            </div>
        </div>
        </p>
        <p>Share your application:
            <a href="#" data-application="{{$property->id}}" id="email-application"><i
                        class="fa fa-envelope-o fa-2x"></i></a>

        </p>
    </div>
</div>
<div id="modal-form" class="modal fade in" aria-hidden="false" style="display: none;">
    <div class="modal-backdrop fade in"></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <form action="" id="application-email-form">
                        <div class='form-row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Tenant Email Address</label>
                                <input type="email" name="email" id="application-email" class='form-control' required>
                            </div>
                        </div>
                        <button class="btn-primary btn pull-right" type="submit">Sent Email</button>
                </div>
                </form>

            </div>
        </div>
    </div>
</div>
