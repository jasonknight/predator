<?php
namespace Codeable;
require_once(__DIR__ . "/iLogger.php");
class DBLogger implements iLogger {
  private $max_lines = 100;
  private $max_kb = 1024;
  private $lines = array();
  private $id;
  private $line_count;
  private $open_files = array();
  public function __construct() {
    ini_set("highlight.comment", "#75715E");
    ini_set("highlight.default", "#F8F8F2");
    ini_set("highlight.html", "#808080");
    ini_set("highlight.keyword", "#F92672; font-weight: bold");
    ini_set("highlight.string", "#E6DB74");
  }
  private function sanityCheck() {
    if ( ! $this->id ) {
      throw new \Exception("Failed Sanity Check: Must set id!");
    }
  }
  public function AddLine($type,$params) {
    if ( $this->max_lines <= 0 ) {
      return;
    }
    if ( $this->line_count + 1 > $this->max_lines ) {
      $this->UnshiftLine();
    } 
    $entry = new \stdClass();
    $entry->type = $type;
    $entry->params = $params;
    $this->line_count++;
    array_push($this->lines,$entry);
  }
  public function UnshiftLine() {
    if ( $this->line_count <= 0 ) {
      throw new \Exception("cannot unshift an empty array");
    }
    $this->lines = array_slice($this->lines,1,$this->line_count - 1);
    $this->line_count--;
  }
  // Make sure to set this to something uniquesque!
  // Like your full plugin name: WPDoesSomething
  public function SetID($id) {
    $this->id = $id;
  }
  public function GetID() {
    return $this->id;
  }
  public function GetLineCount() {
    return $this->line_count;
  }
  private function addBlock($bt,$params) {
    $file = $bt[0]['file'];
    $line = $bt[0]['line'];
    if ( ! isset($this->open_files[$file]) ) {
      $this->open_files[$file] = file($file);
    } 
    $block = \join( array_slice($this->open_files[$file],$line-3,5));
    $block = \highlight_string("$file:$line\n<?php \n" . $block,true);
    $params = \array_merge(array('block',$block),$params);
    return $params;
  }
  public function Info(...$params) {
    $params = $this->addBlock(\debug_backtrace(),$params);
    $this->AddLine("INFO",$params);
  }
  public function Error(...$params) {
    $params = $this->addBlock(\debug_backtrace(),$params);
    $this->AddLine("ERROR",$params);
  }
  public function Debug(...$params) {
    $params = $this->addBlock(\debug_backtrace(),$params);
    $this->AddLine("DEBUG",$params);
  }
  public function LastLine() {
    return $this->lines[ $this->line_count - 1 ];
  }
  public function LastLines($n) {
    $cnt = $this->line_count;
    if ( $n > $cnt ) {
      return $this->lines;
    }
    return array_slice( $this->lines, $cnt - $n, $n );
  }
  public function Lines() {
    return $this->lines;
  }
  public function SetMaxLinesKept($n) {
    $this->max_lines = $n;
  }
  public function GetMaxLinesKept() {
    return $this->max_lines;
  }
  public function Save() {
    update_option("{$this->id}_DBLogger",$this->lines);
  }
  public function Load() {
    $this->lines = get_option("{$this->id}_DBLogger",array());
  }
  public function WordPressInit() {
    add_action( 'shutdown', array($this,'Save') );
    add_action( 'wp_footer', array($this,'wp_footer') );
    add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_scripts') );
    add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_scripts') );
  }
  public function wp_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), true); // all the bootstrap javascript goodness
    wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
  }
  public function admin_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
  }
  public function wp_footer() {
    ?>
      <style>
        #DBLoggerContainer {
          position: fixed;
          z-index: 1002;
          left: 0;
          bottom: 0;
          background-color: grey;
          color: black;
          padding: 5px;
          width: 100%;
        }
        #DBLoggerContainer > div.logger {
          position: relative;
          float: left;
          min-width: 100px;
          margin-right: 5px;
        }
        #DBLoggerLines {
          background-color: grey;
          padding: 20px;
          width: 90%;
          height: 80%;
          overflow-y: scroll;
          overflow-x: hidden;
          z-index: 1001;
          border-radius: 5px;
        }
        #DBLoggerLines * code {
          background-color: #272822;
        }
        #DBLoggerLines * .dblogger-file-line  {
          background-color: #272822;
          padding: 10px;
          border: 1px solid black;
          border-radius: 5px;
        }
        #DBLoggerLines * .dblogger-var {
          float: left;
          background-color: #272822;
          color: white;
          padding: 5px;
          border-radius: 3px;
          margin: 3px;
        }
      </style>
      <div id="<?php echo $this->GetID(); ?>_Entry_Template" style="display:none;">
        <div class="row">
          <div class="col-md-12">
            <h2 class="dblogger-type"></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="dblogger-file-line"></div>
          </div>
          <div class="col-md-6 dblogger-vars">
            
          </div>
        </div>
      </div>
      <script type="text/javascript">
        (function ($) {
          var lines = <?php echo json_encode($this->lines); ?>;

          $(function() {
            var container = $('#DBLoggerContainer');
            if ( container.length == 0 ) {
              $('body').append('<div id="DBLoggerContainer" class="container"></div>');
              container = $('#DBLoggerContainer');
            }
            var logger = $('<div class="logger btn btn-primary"><?php echo $this->GetID(); ?> </div>');
            container.append(logger);
            logger.on('click',function() {
              $('body').find("#DBLoggerLines").remove();
              var logger_lines = $('<div id="DBLoggerLines" class="container"></div>');
              var template = $($('#<?php echo $this->GetID(); ?>_Entry_Template').html());
              for ( var i = 0; i < lines.length; ++i) {
                var this_t = template.clone(true);
                var this_e = lines[i];
                this_t.find('.dblogger-type').text(this_e['type']);
                this_t.find('.dblogger-file-line').html(this_e['params'][1]);
                // Now the first part of params is block, and the second
                // is the call site code
                for ( var j = 2; j < this_e['params'].length; j+=2 ) {
                  var v = this_e['params'][j];
                  var vv = this_e['params'][j+1];
                  var logged_var = $('<div class="dblogger-var"></div>');
                  logged_var.html(v + '=' + vv);
                  this_t.find('.dblogger-vars').append(logged_var);
                }
                logger_lines.append(this_t);
              }
              logger_lines.css({'bottom': container.height()-4,'position': 'fixed','left': 0});
              $('body').append(logger_lines);
            });
          });
        })(jQuery);
      </script>
    <?php
  }
}