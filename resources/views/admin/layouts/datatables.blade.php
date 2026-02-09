<script>
$(document).ready(function () {
    $('.datatable').DataTable({
        pageLength: 100,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>
