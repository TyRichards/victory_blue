<?php 

#==================================================================
#
#	Create page output based on type of page
#
#==================================================================

#-----------------------------------------------------------------
# Check the page type for template selection
#-----------------------------------------------------------------

$pageType = checkPageType($post->ID);



#-----------------------------------------------------------------
# Include the template and output selected page type 
#-----------------------------------------------------------------

switch ($pageType) {

	case 'blog':
		include(TEMPLATEPATH."/blog.php");
		break;
	
	case 'portfolio':
		include(TEMPLATEPATH."/portfolio.php");
		break;
	
	default:
		include(TEMPLATEPATH."/page-default.php");

}
?>