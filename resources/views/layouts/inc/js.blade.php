<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/datatable.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.js') }}"></script>

<script>
    $(document).ready(function(){
        
        addStudent();
        showStudent();
        registerInputEvents();
        getStudentData();
        updateStudent();
        deleteStudent();

        
    })

    //function to delete students
    function deleteStudent(){
        $(document).on('click', '.btn_delete', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_student') }}",
                        method: 'post',
                        data:{id:id, 
                        _token: "{{ csrf_token() }}"},
                        success: function(res){
                            if(res.status == 200 ){
                                Swal.fire(
                                    'Deleted!',
                                    'Student deleted successfully.',
                                    'success'
                                )
                                showStudent();
                            }
                        }

                    })
                
                }
              })
        });
    }

    //function to update the students data
    function updateStudent(){
        $(document).on('submit', '#update_student_form', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $('#btn_update_student').text('Updating...');

            $.ajax({
                url: "{{ route('update_student') }}",
                method: "post",
                data:fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res){
                    if(res.status == 200){
                        Swal.fire(
                            'Updated!',
                            'Student updated successfully.',
                            'success'
                        );
                        $('#update').modal('hide');
                        $('#btn_update_student').text('Update Student');
                        showStudent();
                    } else {

                        $('#btn_update_student').text('Update Student');
                        const {name, email} = res.errors;

                        if(name){
                            $('#up_name').tooltip('dispose');
                            $('#up_name').focus();
                            $('#up_name').attr('data-bs-title', name[0]);
                            $('#up_name').addClass('border-danger');
                            $('#up_name').tooltip('show');

                        } else if(email){
                            if(!name){
                                $('#up_email').tooltip('dispose');
                                $('#up_email').focus();
                                $('#up_email').attr('data-bs-title', email[0]);
                                $('#up_email').addClass('border-danger');
                                $('#up_email').tooltip('show');
                            }
                        }
                    }
                }
            })
        })
    }

    //function to get the data of students for update
    function getStudentData(){
        $(document).on('click', '.btn_edit', function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            $('#update').modal('show');
            $.ajax({
                url: "{{ route('get_student_data') }}",
                method: 'get',
                data: {id:id,
                _token: "{{ csrf_token() }}"},
                success: function(res){
                    const { id, profile, name, email } = res;
                        $('#id').val(id);
                        $('#old_profile').val(profile);
                        $('#up_name').val(name);
                        $('#up_email').val(email);
                        $('#thumbnail').html(`<img src="storage/assets/images/${profile}"
                        class="img-thumbnail img-fluid" width="100">`);
                }
            })
        })
        $(document).on('hidden.bs.modal', '#update', function(){
            $('#update_student_form').trigger('reset');
            $('#thumbnail').html('');

        })
    }

    //function for events
    function registerInputEvents(){
        $(document).on('input', '#name',function(){
            let name = $(this).val();
            if(name.length > 0){
                $('#name').tooltip('dispose');
                $('#name').removeClass('border-danger');
            }
            
        })
        $(document).on('input', '#email',function(){
            let email = $(this).val();
            if(email.length > 0){
                $('#email').tooltip('dispose');
                $('#email').removeClass('border-danger');
            }
        })
        $(document).on('input', '#profile',function(){
            let profile = $(this).val();
            if(profile.length > 0){
                $('#profile').tooltip('dispose');
                $('#profile').removeClass('border-danger');
            }
        })
        $(document).on('input', '#up_name',function(){
            let up_name = $(this).val();
            if(up_name.length > 0){
                $('#up_name').tooltip('dispose');
                $('#up_name').removeClass('border-danger');
            }
            
        })
        $(document).on('input', '#up_email', function () {
                let up_email = $(this).val();
                let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

                if (up_email.length > 0 && emailPattern.test(up_email)) {
                    
                    $('#up_email').tooltip('dispose');
                    $('#up_email').removeClass('border-danger');
                }
            });
        $(document).on('input', '#up_profile',function(){
            let up_profile = $(this).val();
            if(up_profile.length > 0){
                $('#up_profile').tooltip('dispose');
                $('#up_profile').removeClass('border-danger');
            }
        })

    }
    //function to show student
    function showStudent(){
        $.ajax({
            url: "{{ route('show_student') }}",
            method: 'get',
            success: function(res){
                $('#table_student').html(res);
                $('table').DataTable();
            }
        })
    }

    //function to add student
    function addStudent(){
        $(document).on('submit', '#register_student_form', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $('#btn_add_student').text('Adding...');

            $.ajax({
                url: "{{ route('add_student') }}",
                method: 'post',
                data:fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res){
                    if(res.status == 200){
                        Swal.fire(
                            'Added!',
                            'Student added successfully.',
                            'success'
                        );
                        $('#btn_add_student').text('Add Student');
                        $('#register_student_form').trigger('reset');
                        $('#registration').modal('hide');
                        showStudent();
                    } else {
                        $('#btn_add_student').text('Add Student');
                        const {name, email, profile} = res.errors
                        if(name){
                            $('#name').tooltip('dispose');
                            $('#name').focus();
                            $('#name').attr('data-bs-title', name[0]);
                            $('#name').tooltip('show');
                            $('#name').addClass('border-danger');
                            
                        } else if(email){
                            if(!name){
                                $('#email').tooltip('dispose');
                                $('#email').focus();
                                $('#email').attr('data-bs-title', email[0]);
                                $('#email').tooltip('show');
                                $('#email').addClass('border-danger');
                            }
                        } else if(profile){
                            if(!name && !email){
                                $('#profile').tooltip('dispose');
                                $('#profile').focus();
                                $('#profile').attr('data-bs-title', profile[0]);
                                $('#profile').tooltip('show');
                                $('#profile').addClass('border-danger');
                            }
                        }
                    }
                    

                }

            })

        })
        
    }

</script>