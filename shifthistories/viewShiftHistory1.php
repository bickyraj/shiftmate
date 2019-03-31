<link href="<?php echo URL_VIEW;?>global\plugins\angular-bootstrap-scrolling-tabs\scrolling-tabs.css" rel="stylesheet" type="text/css"/>

<div class="scrolling-tabs-container" ng-controller="MainCtrl as main">
 
  <!-- Scrolling Nav tabs -->
  <scrolling-tabs tabs="{{main.tabs}}"
                  prop-pane-id="paneId"
                  prop-title="title"
                  prop-active="active"
                  prop-disabled="disabled"
                  tab-click="main.handleClickOnTab($event, $index, tab);">
  </scrolling-tabs>
 
  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane" ng-class="{ 'active': tab.active }" id="{{tab.paneId}}"
                                    ng-repeat="tab in main.tabs">{{tab.content}}</div>
  </div>
 
</div>

<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/angular-bootstrap-scrolling-tabs/scrolling-tabs.js"></script> 
<script src="<?php echo URL_VIEW;?>global/plugins/angular-bootstrap-scrolling-tabs/scrolling-tabs.min.js"></script>
<script type="text/javascript">
  var tabs = [
  { paneId: 'tab01', title: 'Tab <em>1</em> of 12', content: 'Tab Number 1 Content', active: true, disabled: false },
  { paneId: 'tab02', title: 'Tab 2 of 12', content: 'Tab Number 2 Content', active: false, disabled: false },
  { paneId: 'tab03', title: 'Tab 3 of 12', content: 'Tab Number 3 Content', active: false, disabled: false },
  { paneId: 'tab04', title: 'Tab 4 of 12', content: 'Tab Number 4 Content', active: false, disabled: false },
  { paneId: 'tab05', title: 'Tab 5 of 12', content: 'Tab Number 5 Content', active: false, disabled: false }
];
</script>
