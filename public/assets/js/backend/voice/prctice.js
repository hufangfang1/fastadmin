define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'voice/prctice/index' + location.search,
                    add_url: 'voice/prctice/add',
                    edit_url: 'voice/prctice/edit',
                    multi_url: 'voice/prctice/multi',
                    import_url: 'voice/prctice/import',
                    table: 'voice_prctice',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'file_path_image', title: __('File_path_image'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.file},
                        {field: 'file_id', title: __('File_id'), operate: 'LIKE'},
                        {field: 'task_id', title: __('Task_id'), operate: 'LIKE'},
                        {field: 'finetuned_output', title: __('Finetuned_output'), operate: 'LIKE'},
                        {field: 'status', title: __('Status'), searchList: {"-1":__('Status -1'),"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'update_time', title: '更新时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'create_time', title: '创建时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        trylisten: function () {
            Form.api.bindevent($("form[role=form]"), function (data) {
                console.log(data);
                Toastr.success('success');
                return false;
            });
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
