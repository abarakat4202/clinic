/**
 * Page List
 */

'use strict';

const resource = 'roles';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  const datatableEl = $('#datatable');
  let datatable;
  //datatable
  if (datatableEl.length) {
    datatable = datatableEl.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + resource,
        dataFilter: function (res) {
            const json = JSON.parse(res);
            json.recordsTotal = json.meta.total;
            json.recordsFiltered = json.meta.total;
            json.data = json.data;
            return JSON.stringify( json );
        }
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'name' },
        { data: 'is_assignable' },
        { data: 'users_count' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          targets: 1,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            return `<span>${full.name}</span>`;
          }
        },
        {
          targets: 2,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $status = full['is_assignable'];
            return `${
              $status
                ? '<i class="ti fs-4 ti-stethoscope text-success"></i>'
                : '<i class="ti fs-4 ti-stethoscope-off text-muted" ></i>'
            }`;
          }
        },
        {
          // User full name
          targets: 3,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            return `<span>${full.users_count}</span>`;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            const editBtn = ! can('Roles::edit') ? '' : `<a class="btn btn-sm btn-icon edit-record" data-id="${full['id']}" href="${baseUrl}roles/${full['id']}/edit"><i class="ti ti-edit"></i></a>`;
            const deleteBtn = ! can('Roles::delete') ? '' : `<button class="btn btn-sm btn-icon delete-record ${full['is_super_admin'] ? 'invisible' : ''}" data-id="${full['id']}"><i class="ti ti-trash"></i></button>`;
            return (
              `<div class="d-inline-block text-nowrap">${editBtn}${deleteBtn}</div>`
            );
          }
        }
      ],
      order: [[1, 'desc']],
      dom:
        '<"row mx-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },
      // Buttons with Dropdown
      buttons: [
        ! can('Roles::add') ? null : {
          text: `<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New Role</span>`,
          className: 'add-new btn btn-primary mx-3',
          action: function ( e, dt, button, config ) {
            window.location = `${resource}/create`;
          },
          attr: {
          }
        }
      ].filter(b => !!b),
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      },
      initComplete: function () {
      }
    });
  }

  // Delete Record
  $(document).on('click', '.delete-record', function () {
    var itemId = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // sweetalert for confirmation of delete
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl+resource}/${itemId}`,
          success: function () {
            datatable.draw();
            // success sweetalert
            toastr.success(
              'Role has been deleted!',
              'Deleted!',
              {
                "closeButton": true,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
              }
            );
          },
          error: function (error) {
            toastr.error(
              'An error occurred!',
              'Error!',
              {
                "closeButton": true,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
              }
            );
          }
        });
      }
    });
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);

});