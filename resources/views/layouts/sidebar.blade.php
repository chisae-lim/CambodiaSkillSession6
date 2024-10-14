<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
    <a href="/" class="d-flex align-items-center justify-content-center">
        <img src="{{ asset('assets/images/WSC2022SE_TP09_Logo_actual_en.png') }}" alt="Logo" height="50"
            class="d-inline-block align-text-top">
    </a>
    <hr>
    <h6>Filter</h6>
    <div class="border border-secondary">
        <ul class="nav nav-pills flex-column m-3">
            <li class="nav-item">
                <label class="my-auto mx-3">From: </label>
                <div class="input-group date" id="from_date_input" data-target-input="nearest">
                    <div class="d-flex justify-content-start">
                        <input v-model="model" class="form-control datetimepicker-input" data-target="#from_date_input">
                        <div class="input-group-append" data-target="#from_date_input" data-toggle="datetimepicker">
                            <div class="input-group-text"><i><img
                                        src="{{ asset('assets/images/PNG/16px/084-calendar.png') }}"
                                        style="width:25px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <label class="my-auto mx-3">To: </label>
                <div class="input-group date" id="to_date_input" data-target-input="nearest">
                    <div class="d-flex justify-content-start">
                        <input v-model="model" class="form-control datetimepicker-input" data-target="#to_date_input">
                        <div class="input-group-append" data-target="#to_date_input" data-toggle="datetimepicker">
                            <div class="input-group-text"><i><img
                                        src="{{ asset('assets/images/PNG/16px/084-calendar.png') }}"
                                        style="width:25px"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <label class="my-auto mx-3">Area: </label>
                <select id="area-select" class="form-select">
                    @foreach ($areas as $area)
                        <option value="{{ $area->GUID }}">{{ $area->Name }}</option>
                    @endforeach
                </select>
            </li>
            <li class="nav-item">
                <label class="my-auto mx-3">Host: </label>
                <select id="host-select" class="form-select">

                </select>
            </li>

            <li class="nav-item">
                <label class="my-auto mx-3">Guest: </label>
                <select id="guest-select" class="form-select">

                </select>
            </li>
        </ul>
    </div>
</div>

<script>
    $(document).ready(async function() {
        $('#from_date_input,#to_date_input').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: moment(),
        });
        $('#area-select').change(async function() {
            await getHostsByAreaID();
            await getGuestsByAreaIDAndHostID();
        });
        $('#host-select').change(async function() {
            await getGuestsByAreaIDAndHostID();
        });

        await getHostsByAreaID();
        await getGuestsByAreaIDAndHostID();
    });
    async function getHostsByAreaID() {
        try {
            const id_area = $('#area-select').val();
            const res = await axios.get('/api/get/hosts/by/area/' + id_area);

            const hosts = res.data;
            $('#host-select').empty();
            hosts.forEach(({
                GUID,
                FullName
            }) => {
                $('#host-select').append(
                    '<option value="' + GUID + '">' + FullName + '</option>'
                );
            });
        } catch (error) {
            console.log(error)
        }
    }
    async function getGuestsByAreaIDAndHostID() {
        try {
            const id_area = $('#area-select').val();
            const id_host = $('#host-select').val();
            console.log(id_area,id_host)
            const res = await axios.get('/api/get/guests/by/area/' + id_area + '/host/' + id_host);

            const guests = res.data;
            $('#guest-select').empty();
            guests.forEach(({
                GUID,
                FullName
            }) => {
                $('#guest-select').append(
                    '<option value="' + GUID + '">' + FullName + '</option>'
                );
            });
            console.log(res.data)
        } catch (error) {
            console.log(error)
        }
    }
</script>
