///*forum-index*/
//      $(window).on('load', function() {
//         $('#forum-table').DataTable({
//            dom: 'lfrtip',
//            autoWidth: false,
//            language: {
//               search: "",
//               searchPlaceholder: "Search"
//            },
//         });
//      });
//   $(function () {
//      $('.delete-icon-btn').click(function () {
//         var forumId = $(this).attr("data-id");
//         deleteForum(forumId);
//      });
//      function deleteForum(forumId) {
//         swal({
//            title: "",
//            text: "Are you sure that you want to delete this?",
//            type: "warning",
//            showCancelButton: true,
//            showLoaderOnConfirm: true,
//            closeOnConfirm: false,
//            confirmButtonText: "Yes, delete it!",
//            confirmButtonColor: "#ec6c62"
//         }, function () {
//            $.ajax({
//               url: "/admin/forums/" + forumId,
//               type: "POST",
//               data: {'_method': 'delete'},
//            }).error(function (data) {
//               swal("Oops", "We couldn't connect to the server!", "error");
//            });
//         });
//      }
//   });
///*end*/
//
///*blog-index*/
//
///*end*/