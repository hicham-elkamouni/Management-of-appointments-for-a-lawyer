<template>
  <div class="container">
    <form class="form_container" @submit.prevent="BookAnAppointement">
      <div class="form_input_container">
        <label class="form_label" for="date">Enter Your Enter your date</label>
        <input
          class="form_input"
          type="date"
          v-model="AppointementDate"
          @change="getAvailableTimes"
        />
      </div>
      <div>
        <label class="form_label" for="Reference"
          >Enter the time you want</label
        >
        <select class="form_input" v-model="timeslot">
          <option value="" selected hidden>choose a timeslot</option>
          <option
            v-for="(time, index) in times_obj"
            :value="time.timeslot_id"
            :key="index"
            >{{ time.start_at }} - {{ time.end_at }}
          </option>
        </select>
      </div>
      <div class="form_input_container">
        <label class="form_label" for="subject">Enter Your Subject</label>
        <input class="form_input" type="text" v-model="subject" />
      </div>
      <button type="submit" class="form_button">book now</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      userId: "",
      date: "",
      obj: "",
      times: "",
      timeslot: "",
      AppointementDate: "",
      subject: "",
      times_obj: {}
    };
  },
  methods: {
    async getAvailableTimes() {
      console.log(this.AppointementDate);
      let obj = {
        c_date: this.AppointementDate
      };
      const response = await axios.post(
        "http://localhost/Management-of-appointments-for-a-lawyer/ApiAppointement/checkAvailableTimes",
        obj
      );
      if (response.data.status == true) {
        this.times_obj = response.data.data;
        console.log(response.data.data);
        console.log(this.times_obj);
      }
    },
    async BookAnAppointement() {
      let obj = {
        userId_fk: sessionStorage.getItem("userId"),
        timeslot_id_fk: this.timeslot,
        user_subject: this.subject,
        c_date: this.AppointementDate
      };
      console.log(obj);

      const response = await axios.post(
        "http://localhost/Management-of-appointments-for-a-lawyer/ApiAppointement/createAnAppointement",
        obj
      );

      if (response.data.status == true) {
        console.log(response.data.message);
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.container {
  display: flex;
  justify-content: center;
}
.form_container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  border: 1px dashed #42b983;
  border-radius: 20px;
  padding: 20px 30px;
  width: 25%;
}
.form_label {
  display: block;
  float: left;
}
.form_input_container {
  display: block;
  margin: 10px;
  width: 100%;
}
.form_input {
  width: 100%;
  padding: 10px 5px;
  margin: 5px auto;
  border: 0 none #ccc;
  border-bottom: 2px solid #42b983;
}
.form_input:focus {
  border: 2px solid #42b983;
  outline: none;
}
.form_button {
  display: block;
  padding: 10px 20px;
  background-color: #42b983;
  border: none;
  border-radius: 20px;
  outline: none;
}
</style>
