@extends('layout.app')

    @section('container')
        <div id="app">

            <div class="offset-md-3 col-md-5">

                <ul class="list-group">
                    <a v-bind:href="message.id" v-on:click.prevent="markAsRead" class="list-group-item list-group-item-action" v-for="message in messages" title="Click to clear this message">
                        @{{message.message}}
                    </a>
                    <li class="list-group-item disabled" v-if="status">No New Message</li>
                </ul>

                <i class="fas fa-bell fa-lg" v-if="status"></i>
                <i class="fas fa-bell fa-lg new" v-else></i>

            </div>

        </div>

        <style>
            .new {
                color: red;
            }
        </style>
    @endsection


    @push('script')
        <script>
            const app = new Vue({
                el: '#app',
                data: {
                    messages: {},
                    status: '',
                },
                mounted() {
                    this.getMessages();
                    this.listen();
                },
                methods: {
                    getMessages() {
                        axios.get('api/messages')
                            .then((result) => {
                                this.messages = result.data
                            }).catch((err) => {
                                console.log(err)
                            });
                    },
                    markAsRead() {
                        var id = event.target.getAttribute('href');

                        axios.patch('api/message/markAsRead/'+id)
                                .then((result) => {
                                    console.log(result.data);
                                    this.getMessages();
                                }).catch((err) => {
                                    console.log(err)
                                });
                    },
                    listen() {
                        Echo.channel('new-message').listen('NewMessage', (e) => {
                            alert("You've got a new messsage");
                            this.messages.unshift(e)
                        });
                    }
                },
                computed: {
                    noMessages() {
                           this.status = this.messages.length > 0 ? false : true
                           return this.status
                    }
                }
            });
        </script>
    @endpush
