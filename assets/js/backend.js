(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
window.addEventListener("load", function (_event) {
  var publishBtn = document.querySelector("#wp-admin-bar-publish-changes");
  var _window = window,
      ajaxurl = _window.ajaxurl,
      jQuery = _window.jQuery,
      tb_show = _window.tb_show;
  publishBtn === null || publishBtn === void 0 ? void 0 : publishBtn.addEventListener("click", function (e) {
    var target = e.target;
    e.preventDefault();

    if (target.getAttribute("disabled") !== "true") {
      target.setAttribute("disabled", "true");
      jQuery.post(ajaxurl, {
        action: "dispatch_deploy"
      }, function (resp) {
        console.log(resp);

        if (resp.OK) {
          tb_show("Changes were successfully published!", "#TB_inline?inlineId=deploy-modal&width=auto");
        } else {
          alert(resp.msg);
        }
      }).always(function () {
        target.removeAttribute("disabled");
      });
    }
  });
});

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvYmFja2VuZC9qcy9tYWluLnRzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7QUNjQSxNQUFNLENBQUMsZ0JBQVAsQ0FBd0IsTUFBeEIsRUFBZ0MsVUFBQyxNQUFELEVBQVc7QUFDekMsTUFBTSxVQUFVLEdBQUcsUUFBUSxDQUFDLGFBQVQsQ0FBdUIsK0JBQXZCLENBQW5CO0FBQ0EsZ0JBQXFDLE1BQXJDO0FBQUEsTUFBUSxPQUFSLFdBQVEsT0FBUjtBQUFBLE1BQWlCLE1BQWpCLFdBQWlCLE1BQWpCO0FBQUEsTUFBeUIsT0FBekIsV0FBeUIsT0FBekI7QUFFQSxFQUFBLFVBQVUsS0FBQSxJQUFWLElBQUEsVUFBVSxLQUFBLEtBQUEsQ0FBVixHQUFVLEtBQUEsQ0FBVixHQUFBLFVBQVUsQ0FBRSxnQkFBWixDQUE2QixPQUE3QixFQUFzQyxVQUFDLENBQUQsRUFBTTtBQUMxQyxRQUFNLE1BQU0sR0FBRyxDQUFDLENBQUMsTUFBakI7QUFDQSxJQUFBLENBQUMsQ0FBQyxjQUFGOztBQUVBLFFBQUksTUFBTSxDQUFDLFlBQVAsQ0FBb0IsVUFBcEIsTUFBb0MsTUFBeEMsRUFBZ0Q7QUFDOUMsTUFBQSxNQUFNLENBQUMsWUFBUCxDQUFvQixVQUFwQixFQUFnQyxNQUFoQztBQUVBLE1BQUEsTUFBTSxDQUNILElBREgsQ0FFSSxPQUZKLEVBR0k7QUFDRSxRQUFBLE1BQU0sRUFBRTtBQURWLE9BSEosRUFNSSxVQUFDLElBQUQsRUFBUztBQUNQLFFBQUEsT0FBTyxDQUFDLEdBQVIsQ0FBWSxJQUFaOztBQUVBLFlBQUksSUFBSSxDQUFDLEVBQVQsRUFBYTtBQUNYLFVBQUEsT0FBTyxDQUNMLHNDQURLLEVBRUwsNkNBRkssQ0FBUDtBQUlELFNBTEQsTUFLTztBQUNMLFVBQUEsS0FBSyxDQUFDLElBQUksQ0FBQyxHQUFOLENBQUw7QUFDRDtBQUNGLE9BakJMLEVBbUJHLE1BbkJILENBbUJVLFlBQUs7QUFDWCxRQUFBLE1BQU0sQ0FBQyxlQUFQLENBQXVCLFVBQXZCO0FBQ0QsT0FyQkg7QUFzQkQ7QUFDRixHQTlCRCxDQUFBO0FBK0JELENBbkNEIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24oKXtmdW5jdGlvbiByKGUsbix0KXtmdW5jdGlvbiBvKGksZil7aWYoIW5baV0pe2lmKCFlW2ldKXt2YXIgYz1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlO2lmKCFmJiZjKXJldHVybiBjKGksITApO2lmKHUpcmV0dXJuIHUoaSwhMCk7dmFyIGE9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitpK1wiJ1wiKTt0aHJvdyBhLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsYX12YXIgcD1uW2ldPXtleHBvcnRzOnt9fTtlW2ldWzBdLmNhbGwocC5leHBvcnRzLGZ1bmN0aW9uKHIpe3ZhciBuPWVbaV1bMV1bcl07cmV0dXJuIG8obnx8cil9LHAscC5leHBvcnRzLHIsZSxuLHQpfXJldHVybiBuW2ldLmV4cG9ydHN9Zm9yKHZhciB1PVwiZnVuY3Rpb25cIj09dHlwZW9mIHJlcXVpcmUmJnJlcXVpcmUsaT0wO2k8dC5sZW5ndGg7aSsrKW8odFtpXSk7cmV0dXJuIG99cmV0dXJuIHJ9KSgpIiwiaW1wb3J0IHR5cGUgalF1ZXJ5IGZyb20gXCJqcXVlcnlcIjtcblxudHlwZSBHbG9iYWxUaGlzID0gdHlwZW9mIGdsb2JhbFRoaXMgJlxuICBXaW5kb3cgJiB7XG4gICAgTmFOOiBuZXZlcjtcbiAgICBJbmZpbml0eTogbmV2ZXI7XG4gIH07XG5cbmludGVyZmFjZSBNeUdsb2JhbCBleHRlbmRzIEdsb2JhbFRoaXMge1xuICBhamF4dXJsOiBzdHJpbmc7XG4gIGpRdWVyeTogdHlwZW9mIGpRdWVyeTtcbiAgdGJfc2hvdyh0aXRsZTogc3RyaW5nLCB1cmw6IHN0cmluZyk6IGJvb2xlYW47XG59XG5cbndpbmRvdy5hZGRFdmVudExpc3RlbmVyKFwibG9hZFwiLCAoX2V2ZW50KSA9PiB7XG4gIGNvbnN0IHB1Ymxpc2hCdG4gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKFwiI3dwLWFkbWluLWJhci1wdWJsaXNoLWNoYW5nZXNcIik7XG4gIGNvbnN0IHsgYWpheHVybCwgalF1ZXJ5LCB0Yl9zaG93IH0gPSB3aW5kb3cgYXMgTXlHbG9iYWw7XG5cbiAgcHVibGlzaEJ0bj8uYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIChlKSA9PiB7XG4gICAgY29uc3QgdGFyZ2V0ID0gZS50YXJnZXQgYXMgSFRNTEVsZW1lbnQ7XG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgaWYgKHRhcmdldC5nZXRBdHRyaWJ1dGUoXCJkaXNhYmxlZFwiKSAhPT0gXCJ0cnVlXCIpIHtcbiAgICAgIHRhcmdldC5zZXRBdHRyaWJ1dGUoXCJkaXNhYmxlZFwiLCBcInRydWVcIik7XG5cbiAgICAgIGpRdWVyeVxuICAgICAgICAucG9zdChcbiAgICAgICAgICBhamF4dXJsLFxuICAgICAgICAgIHtcbiAgICAgICAgICAgIGFjdGlvbjogXCJkaXNwYXRjaF9kZXBsb3lcIixcbiAgICAgICAgICB9LFxuICAgICAgICAgIChyZXNwKSA9PiB7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhyZXNwKTtcblxuICAgICAgICAgICAgaWYgKHJlc3AuT0spIHtcbiAgICAgICAgICAgICAgdGJfc2hvdyhcbiAgICAgICAgICAgICAgICBcIkNoYW5nZXMgd2VyZSBzdWNjZXNzZnVsbHkgcHVibGlzaGVkIVwiLFxuICAgICAgICAgICAgICAgIFwiI1RCX2lubGluZT9pbmxpbmVJZD1kZXBsb3ktbW9kYWwmd2lkdGg9YXV0b1wiXG4gICAgICAgICAgICAgICk7XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICBhbGVydChyZXNwLm1zZyk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgfVxuICAgICAgICApXG4gICAgICAgIC5hbHdheXMoKCkgPT4ge1xuICAgICAgICAgIHRhcmdldC5yZW1vdmVBdHRyaWJ1dGUoXCJkaXNhYmxlZFwiKTtcbiAgICAgICAgfSk7XG4gICAgfVxuICB9KTtcbn0pO1xuIl19
