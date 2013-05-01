<?php
/**
 * A Source-page controller
 * 
 * @package NexusMe
 */
class CCSource extends CObject implements IController {

  private $sourceModel;
	

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
    $this->sourceModel = new CMSource();
  }


  /**
   * Implementing interface IController. All controllers must have an index action.
   */
  public function Index() {
    $this->Display();
  }
  
  
  /**
   * Display requested directory and/or file
   */
  public function Display() {
//	print '<pre>';
//	print_r( $this );
//	exit;
    $this->views->SetTitle('Källkod - Nexus');
	
	$this->sourceModel->Init("{$this->request->base_url}{$this->request->controller}/{$this->request->method}", $this->request->arguments);
	$treeNavLinks = 		$this->sourceModel->GetTreeNavLinks();
	$filesAndFolderLinks = 	$this->sourceModel->GetFilesAndFolderLinks();
	$fileInfo = 			$this->sourceModel->GetFileContents();

    $this->views->AddInclude(__DIR__ . '/source.tpl.php', array(
		'treeNavLinks'		  => $treeNavLinks,
		'filesAndFolderLinks' => $filesAndFolderLinks,
		'fileInfo'		  	  => $fileInfo
	) );
  }

  } 