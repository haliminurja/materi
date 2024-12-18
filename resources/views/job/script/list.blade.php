<script defer>
    load_data();

    function load_data() {
        $.fn.dataTable.ext.errMode = 'none';

        $('#example').DataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 15, 20, 25],
                [10, 15, 20, 25]
            ],
            language: {
                processing: '<p>Please wait...</p>'
            },
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            scroller: {
                loadingIndicator: true
            },
            deferRender: true,
            destroy: true,
            ajax: {
                url: '{{ route('job.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                    data: "DT_RowIndex",
                    render: function(data) {
                        return data != null ? data : "";
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: "action",
                    render: function(data) {
                        let btnEdit = `
                        <button
                            type="button"
                            class="btn btn-sm btn-warning m-1"
                            data-id="${data}"
                            title="Edit"
                            data-bs-toggle="modal"
                            data-bs-target="#form_edit">
                            Edit
                        </button>`;
                        let btnDelete = `
                        <button
                            type="button"
                            class="btn btn-sm btn-danger m-1"
                            onclick="deleteConfirmation('${data}')"
                            title="Delete">
                            Delete
                        </button>`;
                        return `${btnEdit} ${btnDelete}`;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: "nama",
                    name: "nama",
                    orderable: true,
                    searchable: true
                },
            ],
        });
    }
</script>
