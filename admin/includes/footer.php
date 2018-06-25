  </div>
    <!-- /#wrapper -->


    

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
	<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Views',         <?= $session->count?>],
          ['Comments',      <?= Comment::count_all()?>],
          ['Users',         <?= User::count_all()?>],
          ['Photos',        <?= Photo::count_all()?>]
        ]);

        var options = {
          legend: 'none',
          pieSliceText: 'label',
          title: 'My Daily Activities',
          backgroundColor: 'transparent'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

    <script src="js/dropzone.js"></script>

    <script src="js/scripts.js"></script>

</body>

</html>
