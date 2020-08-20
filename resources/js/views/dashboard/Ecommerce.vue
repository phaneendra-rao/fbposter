<template>
  <div>
    <v-container fluid class="pt-0 grid-list-xl">
      <section-tooltip
        :title="$t('message.overview')"
        :tooltip="$t('message.dashboardOverview')"
      ></section-tooltip>
      <!-- Dash Cards -->
      <v-row class="border-rad-sm overflow-hidden">
        Dashboard Coming Soon
      </v-row>
    </v-container>
  </div>
</template>

<script>
// charts component
import LineChartShadow from "Components/Charts/LineChartShadow";
import Sales from "Components/Charts/SalesChartV2";
import LineChartWithArea from "Components/Charts/LineChartWithArea";

// // widgets
import RecentSale from "Components/Widgets/RecentSales";
import SupportRequest from "Components/Widgets/SupportRequestV2";
import ToDoList from "Components/Widgets/ToDoList";
import Invoice from "Components/Widgets/Invoice";
import RecentOrders from "Components/Widgets/RecentOrders";
import WeeklySales from "Components/Widgets/WeeklySales.vue";
import Reviews from "Components/Widgets/Reviews";
import SocialFeeds from "Components/Widgets/SocialFeeds";
import TopSelling from "Components/Widgets/TopSelling";
import NewPost from "Components/Widgets/AddNewBlog";
import BlogLayoutOne from "Components/Widgets/BlogLayoutOne";
import BlogLayoutFour from "Components/Widgets/BlogLayoutFour";
import CategorySale from "Components/Widgets/CategorySales";
import DeviceShare from "Components/Widgets/DeviceShare";

import { ChartConfig } from "Constants/chart-config";

export default {
  components: {
    LineChartShadow,
    RecentSale,
    SupportRequest,
    Sales,
    ToDoList,
    Invoice,
    RecentOrders,
    CategorySale,
    LineChartWithArea,
    WeeklySales,
    Reviews,
    SocialFeeds,
    TopSelling,
    NewPost,
    BlogLayoutOne,
    BlogLayoutFour,
    DeviceShare
  },
  data() {
    return {
      blog: {
        id: 3,
        thumbnail: "/static/img/blog-3.jpg",
        title: "lorem ipsum is simply dummy text",
        body:
          "Consectetur adipisicing elit. Ullam expedita, necessitatibus sit exercitationem aut quo quos inventore similique nulla minima distinctio illo iste dignissimos vero nostrum, magni pariatur delectus natus.",
        date: "1-jun-2018"
      },
      ChartConfig,
      labels: ["A", "B", "C", "D", "E", "F", "J", "K", "L", "M", "N", "P"],
      totalEarnings: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44],
      onlineRevenue: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44],
      newCustomers: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44]
    };
  }
};
</script>
