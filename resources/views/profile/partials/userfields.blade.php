@include('flash::message')

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Name</label>
    <div class="col-md-6">
        {!! Form::text('name', NULL, ['class' => 'form-control', 'autofocus' => 'autofocus', 'required' => 'required']) !!}

        @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
    <label for="username" class="col-md-4 control-label">Username</label>
    <div class="col-md-6">
        {!! Form::text('username', NULL, ['class' => 'form-control', 'required' => 'required']) !!}

        @if ($errors->has('username'))
        <span class="help-block">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="col-md-4 control-label">E-mail</label>
    <div class="col-md-6">
        {!! Form::email('email', NULL, ['class' => 'form-control', 'required' => 'required']) !!}

        @if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>
</div>

@if(!isset($user))
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="password" class="col-md-4 control-label">Password</label>
    <div class="col-md-6">
        {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}

        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    <label for="password_confirmation" class="col-md-4 control-label">Repeat
        password</label>
        <div class="col-md-6">
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required']) !!}

            @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
            @endif
        </div>
    </div>
    @endif

    <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }}">
        <label for="contact_no" class="col-md-4 control-label">Contact no</label>
        <div class="col-md-6">
            {!! Form::number('contact_no', NULL, ['class' => 'form-control']) !!}

            @if ($errors->has('contact_no'))
            <span class="help-block">
                <strong>{{ $errors->first('contact_no') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
        <label for="gender" class="col-md-4 control-label">Gender</label>
        <div class="col-md-6">
            {!! Form::radio('gender', 'male', TRUE, ['class' => 'radio']) !!}
            <label>Male</label>
            {!! Form::radio('gender', 'female', False, ['class' => 'radio']) !!}
            <label>Female</label>

            @if ($errors->has('gender'))
            <span class="help-block">
                <strong>{{ $errors->first('gender') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
        <label for="country" class="col-md-4 control-label">Country</label>
        <div class="col-md-6">
            {!! Form::select('country', ['India' => 'India', 'USA' => 'USA'], NULL, ['class' => 'form-control']) !!}

            @if ($errors->has('country'))
            <span class="help-block">
                <strong>{{ $errors->first('country') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('hobbies') ? ' has-error' : '' }}">
        <label for="hobbies" class="col-md-4 control-label">Hobbies</label>
        <div class="col-md-6">
            {!! Form::checkbox('hobbies[]', 'Playing cricket', NULL, ['class' => 'checkbox']) !!}
            <label>Playing cricket</label>
            {!! Form::checkbox('hobbies[]', 'Playing chess', NULL, ['class' => 'checkbox']) !!} 
            <label>Playing chess</label>
            <br>
            {!! Form::checkbox('hobbies[]', 'Internet surfing', NULL, ['class' => 'checkbox']) !!}
            <label>Internet surfing</label>
            {!! Form::checkbox('hobbies[]', 'Outing', NULL, ['class' => 'checkbox']) !!}
            <label>Outing</label>
            {!! Form::checkbox('hobbies[]', 'Reading', NULL, ['class' => 'checkbox']) !!}
            <label>Reading</label>

            @if ($errors->has('hobbies'))
            <span class="help-block">
                <strong>{{ $errors->first('hobbies') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('about_me') ? ' has-error' : '' }}">
        <label for="about_me" class="col-md-4 control-label">About me</label>

        <div class="col-md-6">
            {!! Form::textarea('about_me', NULL, ['class' => 'form-control']) !!}
            @if ($errors->has('about_me'))
            <span class="help-block">
                <strong>{{ $errors->first('about_me') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
        <label for="date_of_birth" class="col-md-4 control-label">Date of birth</label>

        <div class="col-md-6">
            <div class="input-group date" id="dob">
                {!! Form::text('date_of_birth', NULL, ['class' => 'form-control']) !!}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            @if ($errors->has('date_of_birth'))
            <span class="help-block">
                <strong>{{ $errors->first('date_of_birth') }}</strong>
            </span>
            @endif
        </div>
    </div>

    @if(isset($user))
    <div class="form-group{{ $errors->has('slack_webhook_url') ? ' has-error' : '' }}">
        <label for="slack_webhook_url" class="col-md-4 control-label">Slack webhook url</label>
        <div class="col-md-6">
            {!! Form::text('slack_webhook_url', NULL, ['class' => 'form-control']) !!}

            @if ($errors->has('slack_webhook_url'))
            <span class="help-block">
                <strong>{{ $errors->first('slack_webhook_url') }}</strong>
            </span>
            @endif
        </div>
    </div>
    @endif

    @if(isset($user->avatar))
    <div class="form-group">
        <label for="avatar" class="col-md-4 control-label">Current profile pic</label>
        <div class="col-md-6">
            <img src="{{ asset(Helper::getImageThumb($user->avatar, 70, 70)) }}" />  
        </div>
    </div>
    @endif   

    <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
        <label for="avatar" class="col-md-4 control-label">Profile pic</label>
        <div class="col-md-6">
            @if(isset($user->avatar))
            {!! Form::file('avatar', ['class' => 'form-control']) !!}
            @else
            {!! Form::file('avatar', ['class' => 'form-control']) !!}
            @endif
            @if ($errors->has('avatar'))
            <span class="help-block">
                <strong>{{ $errors->first('avatar') }}</strong>
            </span>
            @endif
        </div>
    </div>

    @if(!isset($user))
    <div class="form-group{{ $errors->has('subscription') ? ' has-error' : '' }}">
        <label for="subscription" class="col-md-4 control-label">Subscription</label>
        <div class="col-md-6">
            {!! Form::select('subscription', ['weekly' => 'Weekly (1000)', 'monthly' => 'Monthly (5000)', 'yearly' => 'yearly (100000)'], NULL, ['class' => 'form-control']) !!}

            @if ($errors->has('subscription'))
            <span class="help-block">
                <strong>{{ $errors->first('subscription') }}</strong>
            </span>
            @endif
        </div>
    </div>
    @endif

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            @if(!isset($user))
        {{--<script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ config('services.stripe.key') }}"
            data-amount="1000"
            data-name="{{ config('app.name') }}"
            data-description=""
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto">
        </script>--}}
        @endif
        {!! Form::submit($btntitle, ['class' => 'btn btn-primary']) !!}
    </div>
</div>