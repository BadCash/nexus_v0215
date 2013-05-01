<?php
/**
 * A Me-page controller
 * 
 * @package NexusMe
 */
class CCMe extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
    //$this->guestbookModel = new CMGuestbook();
  }


  /**
   * Implementing interface IController. All controllers must have an index action.
   */
  public function Index() {
	Hem();
  }
  
  
  /**
   * Display Me-page
   */
  public function Hem() {
    $this->views->SetTitle('Om mig - Nexus');
	$content = file_get_contents( __DIR__ . '/hem.md' );
	$content = CTextFilter::Filter($content, array('markdown', 'clickable', 'smartypants'));
    $this->views->AddInclude(__DIR__ . '/hem.tpl.php', array('content' => $content) );
  }

  /**
   * Display Redovisnings -page
   */
  public function Redovisning() {
    $this->views->SetTitle('Redovisning - Nexus');
	$content = file_get_contents( __DIR__ . '/redovisning.md' );
	$content = CTextFilter::Filter($content, array('markdown', 'clickable', 'smartypants'));
    $this->views->AddInclude(__DIR__ . '/redovisning.tpl.php', array('content' => $content) );
  }

  } 