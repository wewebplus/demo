<?php include("../../lib/inc.config.php");?>
<?php $adminprofile = "profile002";?>
<?php include("../home/inc-header-db.php");?>
<!DOCTYPE html>
<html>

<head>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title><?php echo _TITLE_SITENAME_?></title>
  <?php include("../home/inc-scriptcss.php");?>

  <!-- Plugin CSS  -->
  <link rel="stylesheet" type="text/css" href="../vendor/plugins/fullcalendar/fullcalendar.min.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../vendor/plugins/magnific/magnific-popup.css">

</head>

<body class="calendar-page">

  <!-- Start: Main -->
  <div id="main">
    <?php include("../home/inc-header.php");?>
		<?php include("../home/inc-leftmenu.php");?>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">
      <?php include("../home/inc-topbar-dropmenu.php");?>
			<?php include("../home/inc-topbar.php");?>

      <!-- Begin: Content -->
      <section id="content" class="table-layout animated fadeIn">

        <!-- begin: .tray-left -->
        <aside class="tray tray-left tray290" data-tray-mobile="#content > .tray-center">


          <!-- Demo HTML - Via JS we insert a cloned fullcalendar title -->
          <div class="fc-title-clone"></div>

          <!-- Demo HTML - Via JS we insert a sync minicalendar -->
          <div class="section admin-form theme-primary">
            <div class="inline-mp minimal-mp center-block"></div>
          </div>

          <h4 class="mt25"> Events
            <a id="compose-event-btn" href="#calendarEvent" data-effect="mfp-flipInY">
              <span class="fa fa-plus-square"></span>
            </a>
          </h4>

          <hr class="mv15 br-light">

          <div id="external-events" class="bg-dotted">

            <!-- Standard Events -->
            <div class='fc-event fc-event-primary' data-event="primary">
              <div class="fc-event-icon">
                <span class="fa fa-exclamation"></span>
              </div>
              <div class="fc-event-desc">
                <b>2:30am - </b>Meeting With Mike</div>
            </div>
            <div class='fc-event fc-event-info' data-event="info">
              <div class="fc-event-icon">
                <span class="fa fa-info"></span>
              </div>
              <div class="fc-event-desc">
                <b>2:30am - </b>Meeting With Mike</div>
            </div>
            <div class='fc-event fc-event-success' data-event="success">
              <div class="fc-event-icon">
                <span class="fa fa-check"></span>
              </div>
              <div class="fc-event-desc">
                <b>2:30am - </b>Meeting With Mike</div>
            </div>
            <div class='fc-event fc-event-warning' data-event="warning">
              <div class="fc-event-icon">
                <span class="fa fa-question"></span>
              </div>
              <div class="fc-event-desc">
                <b>2:30am - </b>Meeting With Mike</div>
            </div>

            <!-- Reoccuring Events -->
            <h6 class="mt20"> Reoccuring Events: </h6>
            <div class='fc-event fc-event-alert event-recurring' data-event="alert">
              <div class="fc-event-icon">
                <span class="fa fa-clock-o"></span>
              </div>
              <div class="fc-event-desc">
                <b>2:30am - </b>Meeting With Mike</div>
            </div>
            <div class='fc-event fc-event-system event-recurring' data-event="system">
              <div class="fc-event-icon">
                <span class="fa fa-bell-o"></span>
              </div>
              <div class="fc-event-desc">
                <b>2:30am - </b>Meeting With Mike</div>
            </div>

          </div>

          <h4 class="mt30"> Labels </h4>

          <hr class="mv15 br-light">

          <ul class="list-group">
            <li class="list-group-item">
              <span class="badge badge-primary">14</span>
              Entertainment
            </li>
            <li class="list-group-item">
              <span class="badge badge-success">9</span>
              Movies
            </li>
            <li class="list-group-item">
              <span class="badge badge-info">11</span>
              TV Shows
            </li>
            <li class="list-group-item">
              <span class="badge badge-warning">18</span>
              Celebs &amp; Gossip
            </li>

          </ul>


        </aside>
        <!-- end: .tray-left -->

        <!-- begin: .tray-center -->
        <div class="tray tray-center">

          <!-- Calendar -->
          <div id='calendar' class="admin-theme"></div>

        </div>
        <!-- end: .tray-center -->

      </section>
      <!-- End: Content -->

      <?php include("../home/inc-footer.php");?>

    </section>

    <!-- Start: Right Sidebar -->
		<?php include("../home/inc-sidebar_right.php");?>
    <!-- End: Right Sidebar -->

  </div>
  <!-- End: Main -->

  <!-- Calendar Event Creation Modal/Form -->
  <div class="admin-form theme-primary popup-basic popup-lg mfp-with-anim mfp-hide" id="calendarEvent">
    <div class="panel">
      <div class="panel-heading">
        <span class="panel-title">
          <i class="fa fa-pencil-square"></i>New Calendar Event
        </span>
      </div>
      <!-- end .form-header section -->

      <form method="post" action="/" id="calendarEventForm">
        <div class="panel-body p25">
          <div class="section-divider mt10 mb40">
            <span>Event Details</span>
          </div>
          <!-- .section-divider -->

          <div class="section row">
            <div class="col-md-6">
              <label for="firstname" class="field prepend-icon">
                <input type="text" name="firstname" id="firstname" class="gui-input" placeholder="Event Coordinator">
                <label for="firstname" class="field-icon">
                  <i class="fa fa-user"></i>
                </label>
              </label>
            </div>
            <!-- end section -->

            <div class="col-md-6">
              <label for="eventDate" class="field prepend-icon">
                <input type="text" id="eventDate" name="eventDate" class="gui-input" placeholder="Event Date">
                <label class="field-icon">
                  <i class="fa fa-calendar"></i>
                </label>
              </label>
            </div>
            <!-- end section -->
          </div>
          <!-- end .section row section -->

          <div class="section">
            <label for="email" class="field prepend-icon">
              <input type="email" name="email" id="email" class="gui-input" placeholder="Contact Email">
              <label for="email" class="field-icon">
                <i class="fa fa-envelope"></i>
              </label>
            </label>
          </div>
          <!-- end section -->

          <div class="section">
            <div class="smart-widget sm-right smr-140">
              <label for="username" class="field prepend-icon">
                <input type="text" name="username" id="username" class="gui-input" placeholder="Event Title">
                <label for="username" class="field-icon">
                  <i class="fa fa-flag"></i>
                </label>
              </label>
              <label for="username" class="button">company.com</label>
            </div>
            <!-- end .smart-widget section -->
          </div>
          <!-- end section -->

          <div class="section">
            <label class="field prepend-icon">
              <textarea class="gui-textarea" id="comment" name="comment" placeholder="Event Description"></textarea>
              <label for="comment" class="field-icon">
                <i class="fa fa-comments"></i>
              </label>
              <span class="input-footer hidden">
                <strong>Hint:</strong>Don't be negative or off topic! just be awesome...</span>
            </label>
          </div>
          <!-- end section -->

        </div>
        <!-- end .form-body section -->
        <div class="panel-footer text-right">
          <button type="submit" class="button btn-primary">Create Event</button>
        </div>
        <!-- end .form-footer section -->
      </form>
    </div>
    <!-- end .admin-form section -->
  </div>


  <!-- BEGIN: PAGE SCRIPTS -->
  <?php
  include("../home/inc-scriptjs.php");
  ?>

  <!-- AdminForms Date/Month Pickers -->
  <script src="../assets/admin-tools/admin-forms/js/jquery-ui-monthpicker.min.js"></script>
  <script src="../assets/admin-tools/admin-forms/js/jquery-ui-datepicker.min.js"></script>

  <!-- Magnific Popup Plugin -->
  <script src="../vendor/plugins/magnific/jquery.magnific-popup.js"></script>

  <!-- FullCalendar Plugin + Moment Dependency -->
  <script src='../vendor/plugins/fullcalendar/lib/moment.min.js'></script>
  <script src='../vendor/plugins/fullcalendar/fullcalendar.min.js'></script>

  <script type="text/javascript">
  jQuery(document).ready(function() {

    // Init FullCalendar external events
    $('#external-events .fc-event').each(function() {
      // store data so the calendar knows to render an event upon drop
      $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true, // maintain when user navigates (see docs on the renderEvent method)
        className: 'fc-event-' + $(this).attr('data-event') // add a contextual class name from data attr
      });

      // make the event draggable using jQuery UI
      $(this).draggable({
        zIndex: 999,
        revert: true, // will cause the event to go back to its
        revertDuration: 0 //  original position after the drag
      });

    });

    var Calendar = $('#calendar');
    var Picker = $('.inline-mp');

    // Init FullCalendar Plugin
    Calendar.fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      editable: true,
      events: [{
          title: 'Sony Meeting',
          start: '2015-05-4',
          end: '2015-05-6',
          className: 'fc-event-success',
        }, {
          title: 'Conference',
          start: '2015-05-14',
          end: '2015-05-16',
          className: 'fc-event-warning'
        }, {
          title: 'System Testing',
          start: '2015-05-26',
          end: '2015-05-28',
          className: 'fc-event-primary'
        },
      ],
      viewRender: function(view) {
        // If monthpicker has been init update its date on change
        if (Picker.hasClass('hasMonthpicker')) {
          var selectedDate = Calendar.fullCalendar('getDate');
          var formatted = moment(selectedDate, 'MM-DD-YYYY').format('MM/YY');
          Picker.monthpicker("setDate", formatted);
        }
        // Update mini calendar title
        var titleContainer = $('.fc-title-clone');
        if (!titleContainer.length) {
          return;
        }
        titleContainer.html(view.title);
      },
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function() {
        // is the "remove after drop" checkbox checked?
        if (!$(this).hasClass('event-recurring')) {
          $(this).remove();
        }
      },
      eventRender: function(event, element) {
        // create event tooltip using bootstrap tooltips
        $(element).attr("data-original-title", event.title);
        $(element).tooltip({
          container: 'body',
          delay: {
            "show": 100,
            "hide": 200
          }
        });
        // create a tooltip auto close timer
        $(element).on('show.bs.tooltip', function() {
          var autoClose = setTimeout(function() {
            $('.tooltip').fadeOut();
          }, 3500);
        });
      }
    });

    // Init MonthPicker Plugin and Link to Calendar
    Picker.monthpicker({
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      showButtonPanel: false,
      onSelect: function(selectedDate) {
        var formatted = moment(selectedDate, 'MM/YYYY').format('MM/DD/YYYY');
        Calendar.fullCalendar('gotoDate', formatted)
      }
    });


    // Init Calendar Modal via "inline" Magnific Popup
    $('#compose-event-btn').magnificPopup({
      removalDelay: 500, //delay removal by X to allow out-animation
      callbacks: {
        beforeOpen: function(e) {
          // we add a class to body indication overlay is active
          // We can use this to alter any elements such as form popups
          // that need a higher z-index to properly display in overlays
          $('body').addClass('mfp-bg-open');
          this.st.mainClass = this.st.el.attr('data-effect');
        },
        afterClose: function(e) {
          $('body').removeClass('mfp-bg-open');
        }
      },
      midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    });

    // Calendar Modal Date picker
    $("#eventDate").datepicker({
      numberOfMonths: 1,
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      showButtonPanel: false,
      beforeShow: function(input, inst) {
        var newclass = 'admin-form';
        var themeClass = $(this).parents('.admin-form').attr('class');
        var smartpikr = inst.dpDiv.parent();
        if (!smartpikr.hasClass(themeClass)) {
          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
        }
      }

    });


  });
  </script>
  <!-- END: PAGE SCRIPTS -->

</body>

</html>
