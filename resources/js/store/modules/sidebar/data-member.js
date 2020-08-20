// Sidebar Routers
export const othermenus = {
  "message.member": [
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
