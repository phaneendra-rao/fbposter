// Sidebar Routers
export const menus = {
  "message.general": [
    {
      action: "zmdi-view-dashboard",
      title: "Dashboard",
      active: true,
      path: "/dashboard/ecommerce"
    },
    {
      action: "zmdi-balance-wallet",
      title: "Groups",
      active: false,
      items: [
        { title: "message.myGroups", path: "/groups/list" },
        { title: "message.addGroup", path: "/groups/add" }
      ]
    },
    {
      action: "zmdi zmdi-accounts-alt",
      title: "User",
      active: false,
      items: [
        { title: "message.myUsers", path: "/users/list" },
        { title: "message.addUser", path: "/users/add" }
      ]
    },
    {
      action: "zmdi zmdi-accounts-alt",
      title: "Logout",
      active: false,
      path: "/logout"
    }
  ]
};
