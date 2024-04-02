@extends('common.page.Master')
@section('noi_dung')

<div class="container">
    <div class="main-body">
        <div class="row ">

            <div class="col-lg" style="width:100%">
                <div class="card align-items-center" style ="width:80%">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src ="{{asset('storage/avatars/user1.jpg' )}}" alt="Admin" class="rounded-circle p-1 bg-primary" width="180">
                                <div class="mt-3">
                                    <h6 style="font-size: 30px">John Doe</h6>
                                </div>
                            </div>
                            <div style="height: 30px"></div>
                            <hr style="width:80%, align:min-content" >
                            <div style="height: 30px"></div>
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" value="John Doe" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" value="john@example.com" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" value="(239) 816-9029" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex flex-column align-items-center text-center">
                                <input type="button" class="btn btn-primary px-4" value="Save Changes" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
