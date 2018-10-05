function initDatePicker(){
    new datepicker({
        dom:document.getElementById('calendar1-wrapper1'),
        mode: 'ru',
        onClickDate:function(date){
            sel_dep = $('#deptid').val();
            //date = date

            if (sel_dep==null) return;
            var my_url='';
            if ($('#clearableListings').length>0) {
                my_url = "listings/ajpost";
                console.log(my_url);
            }
            if ($('#clearableQuotas').length>0) {
                my_url = "quotas/ajpost";
                console.log(my_url);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: my_url,
                method: 'post',
                data: {
                    dep_id: sel_dep,
                    date: date
                },
                success: function(result){
                    console.log(result);
                    buildNewTable(result);
                },
                fail: function() {
                    console.log('somethingwentwrong');
                }});
        }
    });
}
function buildNewTable(queryResults) {
    if ($('#clearableListings').length>0) {
        BuildListings(queryResults);
    }
    if ($('#clearableQuotas').length>0) {
        BuildQuotas(queryResults);
    }
}
function BuildListings(queryResults){
    var results = JSON.parse(queryResults.listings);
    console.log(results);
    if (results.length<1) $('#clearableListings').html("На выбранную дату ещё не создано записей");
    else{
        var html_dt='';
        results.forEach(function(item,i,results){
            var line = '<tr>';
            line=line+'<td>'+item.dep_id+'</td>';
            line=line+'<td>'+item.patient_name+'</td>';
            line=line+'<td>'+item.phone+'</td>';
            line=line+'<td>'+item.in_date+'</td>';
            line=line+'<td>'+'</td>';
            line+='</tr>';
            html_dt+=line;
        });
        $('#clearableListings').html(html_dt);
    }
}
function BuildQuotas(queryResults){
    var results = JSON.parse(queryResults.querys);
    console.log(results);
    if (results.length<1) $('#clearableQuotas').html("На выбранную дату ещё не создано квот");
    else{
        var html_dt='';
        results.forEach(function(item,i,results){
            var line = '<tr>';
            line=line+'<td>'+item.dep_id+'</td>';
            line=line+'<td>'+item.qtty+'</td>';
            line=line+'<td>'+item.qttyused+'</td>';
            line=line+'<td>'+item.date+'</td>';
            line=line+'<td>'+'</td>';
            line+='</tr>';
            html_dt+=line;
        });
        $('#clearableQuotas').html(html_dt);
    }
}
