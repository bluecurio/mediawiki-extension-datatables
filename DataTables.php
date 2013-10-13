<?php
/**
 * This extension adds the jQuery DataTables extension to Mediawiki. 
 *
 * Author:
 *   Mediawiki extension    Daniel Renfro [ drenfro@vistaprint.net ]
 *   jQuery extension       Allan Jardine [ datatables.net/support ]
 */


// ============ check if we're inside MediaWiki =======================
if ( !defined('MEDIAWIKI') ) {
    echo <<<EOT
To install this extension, you'll need to edit your LocalSettings.php with
the appropriate configuration directives. Please see the README that comes
with the software, or contact your system administrator with this message.
EOT;
    exit( 1 );
}


// ============= default global variables, constants, etc. =====================
define( 'MW_DATATABLES_VERSION', '1.1' );
define( 'DATATABLES_VERSION', '1.9.4' );

// ============ credits =================================
$wgExtensionCredits['other'][] = array(
	'name' 			=> 'DataTables',
	'description' 	=> 'Datatables jQuery library for MediaWiki',
	'author' 		=> array(
		'[[User:Drenfro|Daniel Renfro]] (Mediawiki Extension)',
		'Allan Jardine (Javascript library)'
	),
	'version' 		=> MW_DATATABLES_VERSION
);


// ============ hooks =================================
$wgHooks['ResourceLoaderRegisterModules'][] = array( new DataTables, 'register' );
$wgHooks['SoftwareInfo'][] = 'wfDataTablesExtensionInfo';

// ============ Global Functions ============================================


/**
 * Adds the version number of Allan Jardine's jQuery extension "DataTables" to 
 * the 'Installed Software' section of Special:Version.
 * 
 * @param mixed $softwareInfo 
 * @access public
 * @return true
 */
function wfDataTablesExtensionInfo( &$softwareInfo ) {
    $softwareInfo['[http://datatables.net DataTables]'] = DATATABLES_VERSION;
    return true;
}


/**
 * Basic class for registering the resources of Datatables (JS/CSS) with the 
 * resource loader.
 *
 * If you'd like to use datatables with your extension, you'll need to list it as a 
 * dependency when registering your extenion's resources with the ResourceLoader.
 * This would be one of the 'ext.*' values below. For example
 *
 *  $dependencies = array(
 *      'ext.datatables',
 *      'ext.datatables.colvis'
 *  );
 *
 */
class DataTables {

    static public function getModules() {
		$path = 'DataTables/';
        return array(
            'ext.datatables' => array(    // the main jQuery.datatable() functionality
                'scripts' => $path . 'media/js/jquery.dataTables.js',
                'styles' => $path . 'media/css/jquery.dataTables.css'
            ),
            'ext.datatables.autofill' => array(
                'scripts' => $path . 'extras/AutoFill/media/js/AutoFill.js',
                'styles' => $path . 'extras/AutoFill/media/css/AutoFill.css',
                'dependencies' => array( 'ext.datatables' )
            ),
            'ext.datatables.colreorder' => array(
                'scripts' => $path . 'extras/ColReorder/media/js/ColReorder.js',
                'styles' => $path . 'extras/ColReorder/media/css/ColReorder.css',
                'dependencies' => array( 'ext.datatables' )
            ),
            'ext.datatables.colvis' => array(
                'scripts' => $path . 'extras/ColVis/media/js/ColVis.js',
                'styles' => $path . 'extras/ColVis/media/css/ColVis.css',
                'dependencies' => array( 'ext.datatables' )
            ),
            'ext.datatables.fixedcolumns' => array(
                'scripts' => $path . 'extras/FixedColumns/media/js/FixedColumns.js',
                'dependencies' => array( 'ext.datatables' )
            ),
            'ext.datatables.fixedheader' => array(
                'scripts' => $path . 'extras/FixedHeader/js/FixedHeader.js',
                'dependencies' => array( 'ext.datatables' )
            ),
            'ext.datatables.keytable' => array(
                'scripts' => $path . 'extras/KeyTable/js/KeyTable.js',
                'dependencies' => array( 'ext.datatables' )
            ),
            'ext.datatables.scroller' => array(
                'scripts' => $path . 'extras/Scroller/media/js/Scroller.js',
                'dependencies' => array( 'ext.datatables' )
            ),
            'ext.datatables.tabletools' => array(
                'scripts' => $path . 'extras/TableTools/media/js/TableTools.js',
                'styles' => $path . 'extras/TableTools/media/css/TableTools.css',
                'dependencies' => array( 'ext.datatables' )
            ),
        );
    }

	public static function register( $resourceLoader ) {
		global $wgExtensionAssetsPath;
		
		$localpath = dirname( __FILE__ );
		$remotepath = "$wgExtensionAssetsPath/DataTables";
		
		foreach ( self::getModules() as $name => $resources ) {
			$resourceLoader->register( 
				$name, new ResourceLoaderFileModule( $resources, $localpath, $remotepath )
			);
		}
		
		return true;
	}
}
