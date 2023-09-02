@extends('layouts.master')
@section('title', 'crud')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card shadow border-primary mt-5">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-primary h2">Manage Students</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registration"><i class="bi bi-plus-circle me-2"></i>Register Student</button>
                    </div>
                    <div class="card-body" id="table_student">
                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- registration modal start --}}
    <div class="modal" id="registration" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Register Student</h3>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="post" id="register_student_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="my-2">
                            <label for="name">Name:</label>
                            <input type="text" data-bs-placement="right" class="form-control" name="name" id="name" placeholder="Name">
                        </div>
                        <div class="my-2">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" data-bs-placement="right"  name="email" id="email" placeholder="Email">
                        </div>
                        <div class="my-2">
                            <label for="profile">Profile:</label>
                            <input type="file" class="form-control" data-bs-placement="right"  name="profile" id="profile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_add_student">Add Student</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- registration modal end --}}


    {{-- update modal start  --}}
    <div class="modal" id="update" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Student</h3>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="post" id="update_student_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="old_profile" name="old_profile">
                    <div class="modal-body">
                        <div class="my-2">
                            <label for="up_name">Name:</label>
                            <input type="text" data-bs-placement="right"  class="form-control" name="name" id="up_name" placeholder="Name">
                        </div>
                        <div class="my-2">
                            <label for="up_email">Email:</label>
                            <input type="text" class="form-control" data-bs-placement="right" name="email" id="up_email" placeholder="Email">
                        </div>
                        <div class="my-2">
                            <label for="up_profile">Profile:</label>
                            <input type="file" class="form-control" data-bs-placement="right"  name="profile" id="up_profile">
                        </div>
                        <div id="thumbnail"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_update_student">Update Student</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- update modal end  --}}

@endsection