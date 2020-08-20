import Full from "Container/Full";

// dashboard components
const Ecommerce = () => import("Views/dashboard/Ecommerce");
const AddUsers = () => import("Views/custompages/addusers");
const MyUsers = () => import("Views/custompages/myusers");
const AddGroups = () => import("Views/custompages/addgroups");
const MyGroups = () => import("Views/custompages/mygroups");
const Myposts = () => import("Views/custompages/createpost");
const CreatePost = () => import("Views/custompages/postcreate");
const EditPost = () => import("Views/custompages/postedit");
const AddMembers = () => import("Views/custompages/addmembers");
const MyMembers = () => import("Views/custompages/mymembers");
const Comments = () => import("Views/custompages/comments.vue");

export default {
  path: "/",
  component: Full,
  redirect: "/default/dashboard/ecommerce",
  children: [
    {
      path: "/default/dashboard/ecommerce",
      component: Ecommerce,
      meta: {
        requiresAuth: true,
        title: "message.ecommerce",
        breadcrumb: null
      }
    },
    {
      path: "/default/users/add",
      component: AddUsers,
      meta: {
        requiresAuth: true,
        title: "message.addUser",
        breadcrumb: null
      }
    },
    {
      path: "/default/users/list",
      component: MyUsers,
      meta: {
        requiresAuth: true,
        title: "message.myUsers",
        breadcrumb: null
      }
    },
    {
      path: "/default/groups/add",
      component: AddGroups,
      meta: {
        requiresAuth: true,
        title: "message.addGroup",
        breadcrumb: null
      }
    },
    {
      path: "/default/groups/list",
      component: MyGroups,
      meta: {
        requiresAuth: true,
        title: "message.myGroups",
        breadcrumb: null
      }
    },
    {
      path: "/default/groups/:id/posts",
      component: Myposts,
      name: "MyPosts",
      meta: {
        requiresAuth: true,
        title: "message.createpost",
        breadcrumb: null
      }
    },
    {
      path: "/default/groups/:id/posts/create",
      component: CreatePost,
      name: "CreatePost",
      meta: {
        requiresAuth: true,
        title: "message.createpost",
        breadcrumb: null
      }
    },
    {
      path: "/default/posts/:group_id/edit/:id",
      component: EditPost,
      name: "EditPost",
      meta: {
        requiresAuth: true,
        title: "message.editpost",
        breadcrumb: null
      }
    },
    {
      path: "/default/groups/:id/addmembers",
      component: AddMembers,
      name: "AddMembers",
      meta: {
        requiresAuth: true,
        title: "message.addmembers",
        breadcrumb: null
      }
    },
    {
      path: "/default/groups/:id/members",
      component: MyMembers,
      name: "MyMembers",
      meta: {
        requiresAuth: true,
        title: "message.mymembers",
        breadcrumb: null
      }
    },
    {
      path: "/default/groups/:id/comments",
      component: Comments,
      name: "Comments",
      meta: {
        requiresAuth: true,
        title: "message.comments",
        breadcrumb: null
      }
    }
  ]
};
