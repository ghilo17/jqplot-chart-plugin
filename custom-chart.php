    <?php
    /** Plugin Name: Custom Chart Plugin
    * Plugin URI:  https://github.com/ghilo17
    * Description: Customized Chart Plugin | A custom jqplot plugin
    * Version: 1.0.0
    * Author: Gimel Contillo | After Image Designs
    * Author URI: http://www.facebook.com/bijuumode
    * License: GPL 2.0
    */



        add_shortcode('display_chart_1','chart_1');

        function chart_1($atts = array()){
            shortcode_atts(array(
                'id_name' => '',
                'chart_title' => '',
                'label1_color' => '',
                'label2_color' => '',   
                'label1_data' => '',
                'label2_data' => ''
            ), $atts);
            $prefix = "var config = {";
            $suffix = "};";

            $the_colors = '\'' . $atts['label1_color'] . '\'' . "," . '\'' . $atts['label2_color'] . '\'';

            $chart_title = "\n\t Chart_Title: ". "'" . $atts['chart_title'] . "'" . "\n,";

            $the_id = "\n\t Id_name: ". '\'' . $atts['id_name'] . '\',';

            $l1_data = "\n\tLabel_1_Data: [". $atts['label1_data'] ."], \n";

            $l2_data = "\n\tLabel_2_Data: [". $atts['label2_data'] ."], \n";

            $colors = "\n\tColors: [". $the_colors ."]\n";

            $file1 = plugin_dir_path( __FILE__ ) . '/config/config.js'; 
            $configFile = fopen($file1, "w");
            fwrite($configFile, $prefix . $the_id . $chart_title . $l1_data . $l2_data . $colors . $suffix);
            fclose($configFile);

            return '<div class="ui-widget ui-corner-all">
           <div class="ui-widget-header ui-corner-top">Admin Entry</div>
           <div class="ui-widget-content ui-corner-bottom">
                <div id="'. $atts['id_name'] .'">
                </div>
            </div>
            </div>';
        }

            add_action( 'wp_enqueue_scripts', 'script_in_header' );
    function script_in_header() {
        wp_enqueue_script( 'jplot', $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/jquery.jqplot.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'dateAxisRenderer', $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/plugins/jqplot.dateAxisRenderer.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'canvasTextRenderer', $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/plugins/jqplot.canvasTextRenderer.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'highlighter', $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/plugins/jqplot.highlighter.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'config', $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/config/config.js');
        wp_enqueue_style( 'jqplot', $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/jquery.jqplot.min.css');
        wp_enqueue_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/smoothness/jquery-ui.css');
        wp_enqueue_style( 'custom-ui', $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/custom.css');
        ?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

            <script>
            jQuery(function(){
                jQuery("head script[src*='jquery.jqplot.min.js']").remove();
            });
            </script>

        <script type="text/javascript">

            jQuery(document).ready(function ($) {
        jQuery.jqplot._noToImageButton = true;
        var prevYear = [["2013-08-01", config.Label_1_Data[0]], ["2014-08-02", config.Label_1_Data[1]], ["2015-08-03", config.Label_1_Data[2]], ["2016-08-04",config.Label_1_Data[3]], ["2017-08-05", config.Label_2_Data[4]]];
     
        var currYear = [["2013-08-01", config.Label_2_Data[0]], ["2014-08-02", config.Label_2_Data[1]], ["2015-08-03", config.Label_2_Data[2]], ["2016-08-04", config.Label_2_Data[3]], ["2017-08-05", config.Label_2_Data[4]]]; 
        var plot1 = jQuery.jqplot(config.Id_name, [prevYear, currYear], {
            seriesColors: [config.Colors[0], config.Colors[1]],
            title: config.Chart_Title,
            highlighter: {
                show: true,
                sizeAdjust: 1,
                tooltipOffset: 9
            },
            grid: {
                background: 'rgba(57,57,57,0.0)',
                drawBorder: false,
                shadow: false,
                gridLineColor: '#666666',
                gridLineWidth: 2
            },
            legend: {
                show: true,
                placement: 'outside'
            },
            seriesDefaults: {
                rendererOptions: {
                    smooth: true,
                    animation: {
                        show: true
                    }
                },
                showMarker: true
            },
            series: [
                {
                    fill: true,
                    label: 'Discretionary Earnings'
                },
                {
                    label: 'Gross Sales'
                }
            ],
            axesDefaults: {
                rendererOptions: {
                    baselineWidth: 1.5,
                    baselineColor: '#444444',
                    drawBaseline: false
                }
            },
            axes: {
                xaxis: {
                    renderer: jQuery.jqplot.DateAxisRenderer,
                    tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                        formatString: "%Y",
                        angle: -30,
                        textColor: '#dddddd'
                    },
                    min: "2013-08-01",
                    max: "2017-09-30",
                    tickInterval: "1 year",
                    drawMajorGridlines: false
                },
                yaxis: {
                    renderer: jQuery.jqplot.LogAxisRenderer,
                    pad: 0,
                    rendererOptions: {
                        minorTicks: 1
                    },
                    tickOptions: {
                        formatString: "$%'d",
                        showMark: true
                    }
                }
            }
        });
     
          jQuery('.jqplot-highlighter-tooltip').addClass('ui-corner-all')
    });
        </script>
        <?php
    }



    ?>
