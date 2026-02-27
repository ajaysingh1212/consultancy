<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    @vite(['resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- DataTables CSS --}}
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link rel="stylesheet"
          href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('admin.layouts.sidebar')

    <div class="flex-1">

        {{-- Header --}}
        @include('admin.layouts.header')

        {{-- Main Content --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>


{{-- ================= SCRIPTS ================= --}}

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

{{-- DataTables --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

{{-- DataTables Buttons --}}
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

{{-- Export Dependencies --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

{{-- DataTable Initializer --}}
<script>
    $(document).ready(function () {
        if ($('.datatable').length) {
            $('.datatable').DataTable({
                pageLength: 100,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        }
    });
</script>

{{-- Page Specific Scripts --}}
@stack('scripts')

</body>
</html>
