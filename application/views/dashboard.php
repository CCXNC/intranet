<canvas id="myChart" width="50px" height="50px"></canvas>

<canvas id="myPie" width="100px" height="50px"></canvas>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    $.post("<?php echo base_url();?>Announcement/get_gender",
        function(data){
            var obj = JSON.parse(data);

            range = [];
            title = [];
            bgColor1 = ['blue','pink'];
            $.each(obj, function(i,gender){
                range.push(gender.gender_name);
                title.push(gender.count_gender);
            });

        var ctx = $("#myChart");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: range,
                datasets: [{
                    label: 'PIE CHART',
                    data: title,
                    backgroundColor: bgColor1,
                    borderColor: bgColor1,
                    borderWidth: 1
                }]
            }
        });    
    });

    var bgColor = [];
    $.post("<?php echo base_url();?>Announcement/get_rank",
        function(data){
            var obj = JSON.parse(data);

            range = [];
            title = [];
            $.each(obj, function(i,rank){
                range.push(rank.count_rank);
                title.push(rank.rank_name);
                bgColor.push('rgba(54, 162, 235, 1)');
            });

            

        var ctx1 = $("#myPie");
        var myChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: title,
                datasets: [{
                    label: 'Employee Rank',
                    data: range,
                    backgroundColor: bgColor,
                    borderColor: bgColor,
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
            }
           
        });    
    });
   
</script>

            

