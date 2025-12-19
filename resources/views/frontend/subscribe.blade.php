@extends('frontend.layouts.main')

@section('content')
    
    <section id="contact" class="contact-area gray-bg pt-50 p-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title mt-45 text-center">
                        <h3 class="title">Try 30 Days Free</h3>
                    </div>
                </div>
                <div class="col-lg-12 mt-2 mb-2">
                    @if(count($errors))
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12">
                    <div class="contact-form form-style-four mt-15">
                        <form id="contact-form" action="{{url('subscribe/user')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-input mt-15">
                                        <label>Full Name</label>
                                        <div class="input-items default">
                                            <i class="lni-user"></i>
                                            <input type="text" name="name" value="{{old('name')}}">
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input mt-15">
                                        <label>Email Address</label>
                                        <div class="input-items default">
                                            <i class="lni-envelope"></i>
                                            <input type="text" name="email" value="{{old('email') ?? @$email}}">
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input mt-15">
                                        <label>Phone Number</label>
                                        <div class="input-items default">
                                            <i class="lni-phone-handset"></i>
                                            <input type="text" name="phone" value="{{old('phone')}}">
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input mt-15">
                                        <label>Password</label>
                                        <div class="input-items default">
                                            <i class="lni-lock"></i>
                                            <input type="password" name="password">
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <div class="col-md-12">
                                    <div class="form-input mt-15">
                                        <label>Institute Name</label>
                                        <div class="input-items default">
                                            <i class="lni-graduation"></i>
                                            <input type="text" name="institute_name" value="{{ old('institute_name') }}">
                                        </div>
                                    </div> <!-- form input -->
                                </div>
                                <div class="col-md-12">
                                    <div class="single-form pt-25">
                                        <div class="input-form rounded-buttons">
                                            <button class="main-btn rounded-three" type="submit">Submit</button>
                                        </div>
                                    </div> <!-- single form -->
                                </div>
                            </div> <!-- row -->
                        </form>
                    </div> <!-- contact form -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
@endsection