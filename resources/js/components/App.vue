<template>
    <div>
        <div class="text-center">
            <v-snackbar
                v-model="snackBarMessage.show"
                timeout="2000"
            >
                {{ snackBarMessage.message }}
            <template v-slot:action="{ attrs }">
                <v-btn
                    :color="(snackBarMessage.error) ? 'red' : 'blue'"
                    text
                    v-bind="attrs"
                    @click="snackBarMessage.show = false"
                >
                    Close
                </v-btn>
            </template>
            </v-snackbar>
        </div>
        <v-row>
            <v-col cols="4">
                <PickCalendarEvent
                    @addEvent="create"
                    @sendError="showMessage"
                />
            </v-col>
            <v-col cols="8">
                <Calendar 
                    :refresh="refreshCalendar"
                    @resetRefresh="reset"
                />
            </v-col>
        </v-row>
    </div>
</template>

<script>
import PickCalendarEvent from './pages/PickCalendarEvent.vue';
import Calendar from './pages/Calendar.vue';

export default {
    components: {
        PickCalendarEvent,
        Calendar
    },
    data() {
        return {
            snackBarMessage: {
                show: false,
                error: false,
                message: ""
            },
            refreshCalendar: false
        }
    },
    methods: {
        create(e, label, code) {
            axios.post(`/api/calendar/events/create`, {
                event_at: e,
                label: label,
                code: code
            })
            .then(res => {
                this.activeMessage(false, true, res.data.data.message);
                this.refreshCalendar = true;
            })
            .catch(err => this.activeMessage(true, true, err.response.data.message));
        },
        activeMessage(error = false, show = false, message = "") {
            this.snackBarMessage.show = show;
            this.snackBarMessage.error = error;
            this.snackBarMessage.message = message;
        },
        showMessage(showErrorMessage = false, error = false, errorMessage = "") {
            this.activeMessage(showErrorMessage, error, errorMessage);
        },
        reset(val) {
            this.refreshCalendar = false;
        }
    }
}
</script>