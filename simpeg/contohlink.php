<?php

include_once( 'ofc-library/open-flash-chart.php' );

// generate some random data
srand((double)microtime()*1000000);

$bar = new bar( 50, '#0066CC' );
$bar->key( 'Kittens', 10 );


for( $i=0; $i<9; $i++ )
{
  // add a bar (of randome height) and a URL link
  $bar->add_link( rand(2,9), "javascript:alert('Kittens: Bar $i')" );
}


$g = new graph();
$g->title( 'Bar Chart', '{font-size: 26px;}' );

$g->data_sets[] = $bar;

//
$g->set_x_labels( array( 'January','February','March','April','May','June','July','August','September' ) );
// set the X axis to show every 2nd label:
$g->set_x_label_style( 10, '#9933CC', 0, 2 );
// and tick every second value:
$g->set_x_axis_steps( 2 );
//

$g->set_y_max( 10 );
$g->y_label_steps( 2 );
$g->set_y_legend( 'Open Flash Chart', 12, '0x736AFF' );
echo $g->render();
?>