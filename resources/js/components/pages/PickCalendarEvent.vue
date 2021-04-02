<template>
  <v-card
    :loading="loading"
    max-width="374"
  >
    <template slot="progress">
      <v-progress-linear
        color="teal accent-4"
        height="10"
        indeterminate
      ></v-progress-linear>
    </template>

    <v-card-title>
    SCHEDULE AN EVENT
    </v-card-title>

    <v-form ref="form">
      <v-card-text>
        <v-col>
          <v-date-picker
              v-model="dates"
              multiple
              no-title
              scrollable
              color="teal"
          >
          </v-date-picker>
        </v-col>
        <v-divider></v-divider>
        <v-col>
          <v-text-field
            v-model="label"
            label="Event Label"
            outlined
            rounded
            :rules="labelRequiredField"
            required
          ></v-text-field>
          <v-chip-group
            v-model="code_selection"
            active-class="teal white--text"
            column
          >
            <v-chip
              v-for="code in codes"
              :key="code.color"
              :color="code.color"
            >
              {{ code.text }}
            </v-chip>
          </v-chip-group>
        </v-col>
      </v-card-text>
    </v-form>

    <v-divider class="mx-4"></v-divider>

    <v-card-actions>
      <v-btn
        color="teal accent-3"
        text
        @click="setEvent(dates)"
        :disabled="add_event_disable"
      >
        Add Event
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
  export default {
    data() {
        return {
            loading: false,
            dates: [],
            label: "",
            code_selection: 0,
            codes: [
              { text: "Reminders", color: "orange"  },
              { text: "Tasks", color: "light-blue" },
              { text: "Meetings", color: "green"  },
            ],
            add_event_disable: false,
            labelRequiredField: [
              v => !!v  || "Label field is required"
            ],
        }
    },
    methods: {
      setEvent (events) {
        if (this.$refs.form.validate()) {
          if (events.length < 1) {
            const message = "Please input event (s)";
            this.$emit('sendError', true, true, message);
          } else {
            this.loading = true;
            this.add_event_disable = true;

            setTimeout(() => {
              this.loading = false ;
              this.add_event_disable = false;
              this.$emit('addEvent', events, this.label, this.codes[this.code_selection].color);
              this.$refs.form.reset();
              this.dates = [];
            }, 2000);
          }
        }
      },
    },
  }
</script>