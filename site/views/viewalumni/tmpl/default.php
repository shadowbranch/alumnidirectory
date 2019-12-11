<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_alumnidirectory
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<div class="alumnidirectory">
	<?php if($this->params->get('show_page_heading')){ ?>
	<div class="page-header">
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	</div>
	<?php } ?>
	
	<div class="page-title">
		<h1>
			<?php echo $this->escape($this->title); ?>
		</h1>
	</div>

	<hr />
	
	<div style="text-align: center; margin-bottom: 10px;">
	<?php echo $this->alphalist; ?>
	</div>
	<div style="text-align: center; margin-bottom: 10px;">
	<?php echo $this->searchBox; ?>
	</div>
	
	<hr />
	
	<div>
	<table border="0">
	<?php echo $this->data; ?>
	</table>
	</div>
</div>