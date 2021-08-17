<template>
  <div class="table-wrapper">
    <table class="fl-table" v-if="app">
      <thead>
        <tr>
          <th>Appointment ID</th>
          <th>Subject</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
          <th>CRUD</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(appointement, index) in appointements_obj"
          :key="appointement.appointement_id"
        >
          <td>{{ index + 1 }}</td>
          <td>{{ appointement.user_subject }}</td>
          <td>{{ appointement.c_date }}</td>
          <td>{{ appointement.start_at }} - {{ appointement.end_at }}</td>
          <td>{{ appointement.appointement_id }}</td>
          <td>
            <button class="btn">update</button>
            <button
              class="btn btn2"
              @click="deleteAnAppointement(appointement.appointement_id)"
            >
              delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <p v-else>There are no appointments</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      appointements_obj: {},
      user_personal_informations: {},
      app: false
    };
  },
  methods: {
    async deleteAnAppointement(id) {
      console.log(id);
      let obj = {
        appointement_id: id
      };
      console.log(obj);
      const response = await axios.delete(
        `http://localhost/Management-of-appointments-for-a-lawyer/ApiAppointement/deleteAnAppointment/${id}`
      );

      if (response.data) {
        console.log(response.data);
      }
      this.getAllAppointements();
    },

    checkuser() {
      let userId = sessionStorage.getItem("userId");
      if (userId != null) {
        this.getAllAppointements();
      } else {
        this.$router.push("/sign");
      }
    },
    async getAllAppointements() {
      let u_id = sessionStorage.getItem("userId");
      let obj = "";
      const response = await axios.get(
        "http://localhost/Management-of-appointments-for-a-lawyer/ApiAppointement/showMyAppointments/" +
          u_id,
        obj
      );

      if (response.data.status == true) {
        this.app = true;
        console.log(response.data);
        this.appointements_obj = response.data.appointements;
        this.user_personal_informations = response.data.personal_infos;
        console.log("obj is : ");
        console.log(this.appointements_obj);
      } else {
        this.app = false;
      }
    }
  },
  beforeMount() {
    this.checkuser();
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
/* Table Styles */

.table-wrapper {
  margin: 10px 70px 70px;
  box-shadow: 0px 35px 50px rgba(0, 0, 0, 0.2);
}

.fl-table {
  border-radius: 5px;
  font-size: 12px;
  font-weight: normal;
  border: none;
  border-collapse: collapse;
  width: 100%;
  max-width: 100%;
  white-space: nowrap;
  background-color: white;
}

.fl-table td,
.fl-table th {
  text-align: center;
  padding: 20px;
}

.fl-table td {
  border-right: 1px solid #f8f8f8;
  font-size: 12px;
}

.fl-table thead th {
  color: #ffffff;
  background: #4fc3a1;
}

.fl-table thead th:nth-child(odd) {
  color: #ffffff;
  background: #324960;
}

.fl-table tr:nth-child(even) {
  background: #f8f8f8;
}

.btn {
  width: 80px;
  height: 25px;
  background-color: #4fc3a1;
  border: none;
  margin: 0px 10px;
  color: #ffffff;
  cursor: pointer;
}

.btn2 {
  background-color: #f25c78;
}
/* Responsive */

@media (max-width: 767px) {
  .fl-table {
    display: block;
    width: 100%;
  }
  .table-wrapper:before {
    content: "Scroll horizontally >";
    display: block;
    text-align: right;
    font-size: 11px;
    color: white;
    padding: 0 0 10px;
  }
  .fl-table thead,
  .fl-table tbody,
  .fl-table thead th {
    display: block;
  }
  .fl-table thead th:last-child {
    border-bottom: none;
  }
  .fl-table thead {
    float: left;
  }
  .fl-table tbody {
    width: auto;
    position: relative;
    overflow-x: auto;
  }
  .fl-table td,
  .fl-table th {
    padding: 20px 0.625em 0.625em 0.625em;
    height: 60px;
    vertical-align: middle;
    box-sizing: border-box;
    overflow-x: hidden;
    overflow-y: auto;
    width: 120px;
    font-size: 13px;
    text-overflow: ellipsis;
  }
  .fl-table thead th {
    text-align: left;
    border-bottom: 1px solid #f7f7f9;
  }
  .fl-table tbody tr {
    display: table-cell;
  }
  .fl-table tbody tr:nth-child(odd) {
    background: none;
  }
  .fl-table tr:nth-child(even) {
    background: transparent;
  }
  .fl-table tr td:nth-child(odd) {
    background: #f8f8f8;
    border-right: 1px solid #e6e4e4;
  }
  .fl-table tr td:nth-child(even) {
    border-right: 1px solid #e6e4e4;
  }
  .fl-table tbody td {
    display: block;
    text-align: center;
  }
}
</style>
