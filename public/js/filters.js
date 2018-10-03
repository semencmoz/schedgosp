function initDatePicker(){
    new datepicker({
        dom:document.getElementById('calendar1-wrapper1'),
        mode: 'ru',
        onClickDate:function(date){
            sel_dep = $('#deptid').val();
            //date = date

            if (sel_dep==null) return;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "/quotas/ajpost",
                method: 'post',
                data: {
                    dep_id: sel_dep,
                    date: date
                },
                success: function(result){
                    console.log(result);
                },
                fail: function() {
                    alert('NO');
                }});
        }
    });
}
