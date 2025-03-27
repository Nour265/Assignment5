
@extends('layout')
@section('title', 'Students')
@section('content')

<div class="container">
    <h2>Student List</h2>

    <input class="form-control" type="text" id="search" placeholder="Search by name">
    <input class="form-control" type="number" id="minAge" placeholder="Min Age">
    <input class="form-control mb-4" type="number" id="maxAge" placeholder="Max Age">

    <table class="table">
        <thead>
            <tr>
                <th>Name</th><th>Age</th><th>Email</th>
            </tr>
        </thead>
        <tbody id="student-table">
        @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->age }}</td>
                <td>{{ $student->email }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



<script>
function fetchStudents() {
    const name = $('#search').val();
    const minAge = $('#minAge').val();
    const maxAge = $('#maxAge').val();

    $.ajax({
        url: "{{ route('students.index') }}",
        type: 'GET',
        data: { name, minAge, maxAge },
        success: function(data) {
            $('#student-table').html(data);
        }
    });
}

$('#search, #minAge, #maxAge').on('input', fetchStudents);
</script>


   

@endsection

