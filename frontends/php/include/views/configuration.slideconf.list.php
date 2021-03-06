<?php
/*
** Zabbix
** Copyright (C) 2001-2015 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


$slideWidget = new CWidget();

// create new hostgroup button
$createForm = new CForm('get');
$createForm->cleanItems();
$createForm->addItem(new CSubmit('form', _('Create slide show')));
$slideWidget->addPageHeader(_('CONFIGURATION OF SLIDE SHOWS'), $createForm);
$slideWidget->addHeader(_('Slide shows'));
$slideWidget->addHeaderRowNumber();

// create form
$slideForm = new CForm();
$slideForm->setName('slideForm');

// create table
$slidesTable = new CTableInfo(_('No slide shows found.'));
$slidesTable->setHeader(array(
	new CCheckBox('all_shows', null, "checkAll('".$slideForm->getName()."', 'all_shows', 'shows');"),
	make_sorting_header(_('Name'), 'name', $this->data['sort'], $this->data['sortorder']),
	make_sorting_header(_('Delay'), 'delay', $this->data['sort'], $this->data['sortorder']),
	make_sorting_header(_('Count of slides'), 'cnt', $this->data['sort'], $this->data['sortorder'])
));

foreach ($this->data['slides'] as $slide) {
	$slidesTable->addRow(array(
		new CCheckBox('shows['.$slide['slideshowid'].']', null, null, $slide['slideshowid']),
		new CLink($slide['name'], '?form=update&slideshowid='.$slide['slideshowid'], 'action'),
		$slide['delay'],
		$slide['cnt']
	));
}

// append table to form
$slideForm->addItem(array(
	$this->data['paging'],
	$slidesTable,
	$this->data['paging'],
	get_table_header(new CActionButtonList('action', 'shows', array(
		'slideshow.massdelete' => array('name' => _('Delete'), 'confirm' => _('Delete selected slide shows?'))
	)))
));

// append form to widget
$slideWidget->addItem($slideForm);

return $slideWidget;
