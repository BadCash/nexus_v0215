<?php

/**
 * A model for displaying source files.
 * 
 * @package NexusMe
 */
class CMSource extends CObject {

	// Class "constants"
	private $HIDE_DB_USER_PASSWORD = TRUE; 	// Show the content of files named config.php, except the rows containing DB_USER, DB_PASSWORD
	private $SEPARATOR = '/';
	private $BASE_PATH = NEXUS_INSTALL_PATH;
	
	
	// Class members
	private $baseUrl;
	private $relFullPath;
	private $fullPath;
	private $fileName;
	private $dirPath;
	private $relDirPath;
	private $dirName;



	/**
	* Constructor
	*/
	public function __construct() {
		parent::__construct();
	}


	public function Init( $baseUrl, $requestArgs ){

		// Determine all sorts of paths and parts thereof
		$this->baseUrl = $baseUrl;
		$this->relFullPath = implode( $this->SEPARATOR, $requestArgs );
		$this->fullPath = $this->BASE_PATH . $this->SEPARATOR . $this->relFullPath;
		$this->fileName = is_file( $this->fullPath ) ? basename( $this->fullPath ) : '';
		$this->dirPath = is_dir( $this->fullPath ) ? $this->fullPath : dirname( $this->fullPath );
		$this->relDirPath = is_dir( $this->fullPath ) ? $this->relFullPath : dirname( $this->relFullPath );
		$this->dirName = basename( $this->dirPath );

		/* DEBUG 
			echo "BASEPATH: ".$this->BASE_PATH."<br>";
			echo "ARGS: ".implode('/', $requestArgs).'<br>';
			echo "fullPath: {$this->fullPath}<br>";
			echo "fileName: {$this->fileName}<br>";
			echo "dirPath: {$this->dirPath}<br>";
			echo "dirName: {$this->dirName}<br>";
			echo "relDirPath: {$this->relDirPath}<br>";
			echo "relFullPath: {$this->relFullPath}<br>";
			echo "baseUrl: ".CNexus::Instance()->request->base_url."<br>";
		*/


		// Security check
		$realBasePath = realpath( $this->BASE_PATH );
		$realFullPath = realpath( $this->fullPath );

		if(	strncmp( $realBasePath, $realFullPath, strlen($realBasePath)) < 0 ) {
			die('Tampering with directory?');
		}
		
	}




	public function GetTreeNavLinks(){
		$relDirPathParts = explode('/', trim($this->relDirPath, '/'));
		$treeLinks = array( 
			array( 'href' 	=> $this->baseUrl, 
				   'text' 	=> basename($this->BASE_PATH) 
			)
		);
		$cumulativeRelPathParts = '';
		
		foreach( $relDirPathParts as $part ){
			if( $part == '.' || $part == '..' ){
				continue;
			}
			$cumulativeRelPathParts .= '/' . $part;
			$treeLinks[] = array( 'href' => "{$this->baseUrl}{$cumulativeRelPathParts}",
								  'text' => $part 
							);
		}

		return $treeLinks;
	}


	
	public function GetFilesAndFolderLinks(){
		// Create list of files and folders
		$list = Array();
		if(is_dir($this->dirPath)) {
			if ($dh = opendir($this->dirPath)) {
				while (($file = readdir($dh)) !== false) {
					if( $file == '.' || $file == '..' ){
						continue;
					}

					if($file != '.' && $file != '..' && $file != '.svn') {
						$curfile = $this->dirPath . $this->SEPARATOR . $file;
						if(is_dir($curfile)) {
							$list[$file] = array( 'type' => 'dir',
												  'href' => $this->baseUrl . (empty($this->relDirPath) ? '' : "/{$this->relDirPath}") . "/{$file}",												  
												  'text' => $file.'/'
											);
						} else if(is_file($curfile)) {
							$list[$file] = array( 'type' => 'file',
												  'href' => $this->baseUrl . (empty($this->relDirPath) ? '' : "/{$this->relDirPath}") . "/{$file}",
												  'text' => $file
											);
						}
					 }
				}
				closedir($dh);
			}
		}

		ksort($list);
		
		return $list;
	}


	
	function GetFileContents(){
		$fileInfo = array();
	
		if( !empty($this->fileName) ) {
			$content = htmlspecialchars(file_get_contents(realpath($this->fullPath), 'FILE_TEXT'));

			// Remove password and user from config.php, if enabled
			if($this->HIDE_DB_USER_PASSWORD == TRUE && $this->fileName == 'config.php') {

				$pattern[0] 	= '/(DB_PASSWORD|DB_USER)(.+)/';
				$replace[0] 	= '/* <em>\1,  is removed and hidden for security reasons </em> */ );';
				
				$content = preg_replace($pattern, $replace, $content);
			}
			
			$fileInfo = array( 	'href' 	  => "{$this->baseUrl}/{$this->relFullPath}", 
								'filename' => $this->fileName, 
								'content'  => $content 
							 );			
		}
		
		return $fileInfo;
	}
	
	
	
}