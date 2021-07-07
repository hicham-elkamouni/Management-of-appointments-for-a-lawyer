<template>
  <div>
    <h1>this is dashboard page</h1>
    <DashboardTable />
  </div>
</template>

<script>
import DashboardTable from "@/components/DashboardTable.vue";

export default {
  name: "dashboard",
  components: {
    DashboardTable
  }
};
</script>

<style>
/* Table Styles */
</style>
