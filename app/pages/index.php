<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Patients values</small>
    </h1>
</section>
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <?php
        $rawData = file_get_contents("./patients.json");
        $patData = json_decode($rawData, true);
        foreach ($patData as $patient) {

            $gluk = $patient['pat_actual_glu'];
            switch ($gluk) {
                case $gluk < 2:
                    $patColor = 'red';
                    break;
                case ($gluk >= 2) && ($gluk < 3.9):
                    $patColor = 'yellow';
                    break;
                case ($gluk >= 3.9) && ($gluk < 7.8):
                    $patColor = 'green';
                    break;
                case ($gluk >= 7.8) && ($gluk < 10):
                    $patColor = 'yellow';
                    break;
                    case $gluk >= 10:
                        $patColor = 'red';
                        break;
                default:
                    $patColor = 'green';
                    break;
            }

            print '<div class="col-lg-3 col-xs-6">';
            print '<a href="./index.php?page=graf"><div class="small-box bg-' . $patColor . '">';
            print '<div class="inner">';
            print '<h3>' . $patient['pat_actual_glu'] . '<small> mmol/L</small></h3>';
            print '<p>' . $patient['pat_first_name'] . ' ' . $patient['pat_second_name'] . '<br />(Room ' . $patient['pat_room'] . ' / Bed ' . $patient['pat_bed'] . ')</p>';
            print '</div>';
            print '<div class="icon">';
            print '<i class="ion ion-person-add"></i>';
            print '</div></div></a></div>';
        }
        ?>
    </div><!-- /.row -->
</section><!-- /.content -->