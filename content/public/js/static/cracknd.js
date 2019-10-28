let Cracknd = {
    Ajax: {
        init: function (route, data, method, absolute_path = true) {
            return new Promise((resolve, reject) => {
                route = (absolute_path) ? BASEURL + route : route;
                switch (method) {
                    case 'GET':
                        $.get(route, data, function (data) {
                            resolve(data)
                        }).fail(() => {
                            swal("Error", "Existe un error al procesar tu solicitud", "error");
                        });
                        break;

                    case 'POST':
                        $.post(route, data, function (data) {
                            resolve(data)
                        }).fail(() => {
                            swal("Error", "Existe un error al procesar tu solicitud", "error");
                        });
                        break;

                    default:
                        $.get(route, data, function (data) {
                            resolve(data)
                        }).fail(() => {
                            swal("Error", "Existe un error al procesar tu solicitud", "error");
                        });
                        break;
                }
            });
        },
        LoadOptions: function (selector, route, data) {
            let preloaded_id = selector.data('id');
            selector.attr('disabled', 'disabled');
            Cracknd.Ajax.init(route, data, 'POST').then(response => {
               let data = $.parseJSON(response);
               let options = '<option value="">- Seleccionar opcion -</option>';
               if(data.status){
                   $.each(data.data, function (i, option) {
                       if(parseInt(option.id) === parseInt(preloaded_id))
                           options += `<option value="${option.id}" selected>${option.nombre}</option>`;
                       else
                           options += `<option value="${option.id}">${option.nombre}</option>`;
                   });
               }
               selector.html(options);
               selector.removeAttr('disabled');
            });
        },
        SweetAlert: function (action, options, route, data, callback) {
            swal({
                title: "¡Importante!",
                text: options.title,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: options.button_color,
                confirmButtonText: options.button_text,
                cancelButtonText: "No",
                showLoaderOnConfirm: true,
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if(isConfirm) {
                    $('button.confirm').html(' <i class="fas fa-cog fa-spin"></i> Procesando').attr('disabled', 'disabled');
                    Cracknd.Ajax.init(route, data, 'POST').then(response => {
                        let data = $.parseJSON(response);
                        if(data.status){
                            $('button.confirm').html(' Ok').removeAttr('disabled');
                            swal({
                                title:"Finalizado",
                                text: data.message,
                                type: "success",
                                showCancelButton: false
                            },
                            function(isConfirm){
                                if(isConfirm) {
                                    callback();
                                }
                            });
                        } else {
                            $('button.confirm').html(' Ok').removeAttr('disabled');
                            swal({"html": true, "title": "Espera, ¡algo ocurrió!", "text": data.message, "type":"error"});
                        }
                    });
                }
            });
        }
    },
    Datatables: {
        options: function() {
            return {bStateSave: true, autoWidth: true, processing: true, serverSide: true}
        },
        render: function (table, route, options) {
            let headers = Cracknd.Datatables.getResponsiveHeaders(table);
            if(options.serverSide)
                return table.DataTable({
                    "bStateSave": options.bStateSave,
                    "autoWidth": options.autoWidth,
                    "processing": options.processing,
                    "serverSide": options.serverSide,
                    "ajax": {
                        "url": BASEURL + route, "type": "POST", "dataType": "JSON",
                        "data": function ( d )  {
                            let inputs = $('.table-input-search');
                            let obj = {};
                            $.each(inputs, function (i, input) {
                                let name = $(input).attr('name');
                                obj[name] = $(input).val();
                            });
                            return $.extend({}, d, obj);
                        }
                    },
                    "language":{"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"},
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        let td = $(nRow).children("td");
                        for (let i = 0; i < td.length; i++){
                            td.eq(i).attr('data-th', (headers[i].th !== undefined) ? headers[i].th : '');
                            td.eq(i).addClass((headers[i].class !== undefined) ? headers[i].class : '');
                        }
                    }
                });
            else
                return table.DataTable({
                    "bStateSave": options.bStateSave,
                    "autoWidth": options.autoWidth,
                    "language":{"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"},
                    "fnCreatedRow": function (nRow, aData, iDataIndex) {
                        let td = $(nRow).children("td");
                        for (let i = 0; i < td.length; i++){
                            td.eq(i).attr('data-th', (headers[i].th !== undefined) ? headers[i].th : '');
                            td.eq(i).addClass((headers[i].class !== undefined) ? headers[i].class : '');
                        }
                    }
                });
        },
        getResponsiveHeaders: function(table){
            let table_headers = table.find('thead th');
            let data = [];
            $.each(table_headers, function (i, table_header) {
                let th_table = $(table_header);
                if(th_table.data('header') !== null)
                    data.push({'index': i, 'th': th_table.data('header'), 'class': th_table.data('class')});
            });
            return data;
        }
    },
    decodeHTMLEntities: function(text) {
        return $("<textarea/>").html(text).text();
    }
};