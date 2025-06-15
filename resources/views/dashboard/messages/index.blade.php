@extends('dashboard.layouts.app')

@section('url_pages')
    <span class="text-gray-700">Dashboard</span>
    <i class="ki-filled ki-right text-gray-500 text-3xs"></i>
    <span class="text-gray-700">Messages</span>
@endsection

@section('style')
    <style>
        .none {
            display: none !important;
        }

        .new_message {
            background-color: rgb(2, 214, 2);
            color: #fff;
            padding: 2px 10px;
            border-radius: 5px;
        }

        .seen_message {
            background-color: #f3f4f6;
            color: rgba(0, 0, 0, 0.447);
            padding: 2px 10px;
            border-radius: 5px;
        }

        .current-message {
            display: flex;
            width: 100dvw;
            height: 100dvh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: rgba(255, 255, 255, 0.717);
            align-items: center;
            justify-content: center;
            z-index: 10000000000000;
        }

        .current-message.none {
            display: none !important;
        }

        .current-message .message-content-container {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            background-color: #fff;
            width: 400px;
            height: fit-content;
            max-width: calc(100% - 40px);
            position: relative;
            display: flex;
            align-items: center;
            padding: 60px 20px 20px;
        }

        .current-message .message-content-container .message-content {
            width: 100%;
            word-wrap: break-word;
            position: relative;
        }

        .current-message .message-content-container .message-content .user {
            position: absolute;
            bottom: 50px;
            left: 50px;
            z-index: 999999999999999999;
        }

        .current-message .close-message {
            position: absolute;
            right: 20px;
            top: 20px;
            cursor: pointer;
            font-size: 1.6rem;
            color: gray;
            border: 1px solid transparent;
            border-radius: 5px;
            padding: 0 3px;
            transition: .2s;
        }

        .current-message .close-message:hover {
            border: 1px solid rgba(128, 128, 128, 0.489);
            color: rgba(128, 128, 128, 0.858);
        }

        .current-message .close-message::selection {
            background-color: transparent;
        }
    </style>
@endsection

@section('content')
    <div class="card min-w-full">
        <div class="card-header none">
            <h3 class="card-title">Messages</h3>
        </div>

        <div class="card-table scrollable-x-auto">
            <div class="scrollable-auto">
                @if (count($messages) == 0)
                    <h5 class="p-3 text-center">No Messages</h5>
                @else
                    <table class="table align-middle text-2sm text-gray-600">
                        <tr class="bg-gray-100">
                            <th class="text-start font-medium min-w-10">#</th>
                            <th class="text-start font-medium min-w-15">Username</th>
                            <th class="text-start font-medium min-w-56">User email</th>
                            <th class="text-start font-medium min-w-16">Status</th>
                            <th class="min-w-16">Actions</th>
                        </tr>
                        @foreach ($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>{{ $message->user->name }}</td>
                                <td>{{ $message->user->email }}</td>
                                <td class="status">
                                    @if ($message->seen)
                                        <span class="seen_message">Seen</span>
                                    @else
                                        <span class="new_message">New</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="menu inline-flex" data-menu="true">
                                        <div class="menu-item" data-menu-item-toggle="dropdown"
                                            data-menu-item-trigger="click|lg:click">
                                            <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                                                <i class="ki-filled ki-dots-vertical"></i>
                                            </button>
                                            <div class="menu-dropdown menu-default w-full max-w-[175px]"
                                                data-menu-dismiss="true">
                                                <form class="menu-item read_message_form"
                                                    action="{{ route('messages.readMessage', $message->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" hidden value="{{ $message->message_content }}"
                                                        class="message_content">
                                                    <input type="text" hidden value="{{ $message->user->name }}"
                                                        class="username">
                                                    <input type="text" hidden value="{{ $message->seen }}"
                                                        class="seen">
                                                    <button class="menu-link" type="submit">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-trash"></i>
                                                        </span>
                                                        <span class="menu-title">Read</span>
                                                    </button>
                                                </form>
                                                <form class="menu-item"
                                                    action="{{ route('messages.destroy', $message->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="menu-link" type="submit">
                                                        <span class="menu-icon">
                                                            <i class="ki-filled ki-trash"></i>
                                                        </span>
                                                        <span class="menu-title">Remove</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>

        <!-- Popup Message -->
        <div class="current-message none">
            <div class="message-content-container">
                <span class="close-message" onclick="handleOpenCloseMessage()">&times;</span>
                <p class="message-content">
                </p>
            </div>
        </div>

        <div class="card-footer justify-center">
            {{ $messages->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        const currentMessage = document.querySelector(".current-message");
        const currentMessageContent = document.querySelector(".message-content-container .message-content");

        async function handleOpenCloseMessage(message = null, username = null) {
            if (message && username) {
                currentMessage.classList.remove("none");
                return currentMessageContent.innerHTML = `${message}<br><br>${username}.`;
            }
            currentMessage.classList.add("none");
        }

        const readMessageForms = document.querySelectorAll("form.read_message_form");
        readMessageForms.forEach(form => {
            console.log(form);
            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                const messageContent = form.querySelector("input.message_content").value;
                const username = form.querySelector("input.username").value;
                const seen = form.querySelector("input.seen").value;
                handleOpenCloseMessage(messageContent, username);
                if (!+seen) {
                    const token = form.querySelector("[name='_token']").value;
                    await fetch(form.action, {
                            method: "PUT",
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                            },
                        }).then((res) => res.json())
                        .then(data => {
                            if (data.success) {
                                const statusTd = form.parentElement.closest("tr").querySelector(
                                    "td.status");
                                console.log(statusTd);
                                if (statusTd) {
                                    statusTd.innerHTML = "<span class='seen_message'>Seen</span>";
                                }
                            }
                        });
                }
            });
        });
    </script>
@endsection
