@extends('layouts.backend')
@section('content')

<style>
    .dashboard-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .dashboard-icon {
        font-size: 36px;
        padding: 15px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .numbers p {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
        color: #6c757d;
    }

    .numbers h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    /* SweetAlert2 Custom Styles */
    .swal2-popup {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .swal2-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .swal2-content {
        padding: 0 1rem 1rem;
    }

    .swal2-html-container {
        padding: 0;
    }

    .modal-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .modal-icon {
        font-size: 24px;
        padding: 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
    }

    .modal-numbers p {
        margin: 0;
        font-size: 12px;
        font-weight: 500;
        color: #6c757d;
    }

    .modal-numbers h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    /* Collapse */
    .custom-pill {
        border-radius: 20px;
        padding: 6px 14px;
        transition: all 0.3s ease;
    }

    .custom-pill.active {
        background-color: #007bff;
        color: #fff;
    }

    .class-content {
        display: none;
        padding: 10px;
        animation: fadeIn 0.3s ease;
    }

    .class-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .class-content {
        margin: 20px 0;
        display: none;
        border-bottom: 1px solid #eee;
        animation: fadeIn 0.3s;
    }

    .class-content.active {
        display: block;
    }

    .floors-grid-view {
        display: flex;
        flex-wrap: wrap;
    }

    .floors-grid-view .class-content {
        width: 33%;
        padding: 0 10px;
        float: left;
    }

    .floor-card-inner {
        height: 100%;
    }
</style>

<div style="overflow: hidden;">
    <div class="container-fluid">

        <!-- Top Row: Cards + Pie Chart -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-warning text-white me-3 flex-shrink-0">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small" style="line-height: 1.2;">{{ _lang('Student Capacity') }}</p>
                                    <h4 class="mb-0 fw-bold">{{ total_student_capacity() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-danger text-white me-3 flex-shrink-0">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small" style="line-height: 1.2;">{{ _lang('Occupied Seats') }}</p>
                                    <h4 class="mb-0 fw-bold">{{ total_student_occupied() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-info text-white me-3 flex-shrink-0">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small" style="line-height: 1.2;">{{ _lang('Vacant Seats') }}</p>
                                    <h4 class="mb-0 fw-bold">{{ total_student_vacant() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-primary text-white me-3 flex-shrink-0">
                                    <i class="ti-credit-card"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small" style="line-height: 1.2;">{{ _lang('Monthly Payments') }}</p>
                                    <h4 class="mb-0 fw-bold">{{ $currency . ' ' . $student_payments }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-success text-white me-3 flex-shrink-0">
                                    <i class="ti-wallet"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small">{{ _lang('Others Income') }}</p>
                                    <h5 class="mb-0 fw-bold">{{ $currency . ' ' . $monthly_income }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-danger text-white me-3 flex-shrink-0">
                                    <i class="ti-stats-down"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small">{{ _lang('Monthly Expense') }}</p>
                                    <h5 class="mb-0 fw-bold">{{ $currency . ' ' . $monthly_expense }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-warning text-white me-3 flex-shrink-0">
                                    <i class="ti-money"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small">{{ _lang('Cash in Hand') }}</p>
                                    <h5 class="mb-0 fw-bold">{{ $cash_in_hand }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-primary text-white me-3 flex-shrink-0">
                                    <i class="ti-credit-card"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small">{{ _lang('Atif Sahb (Bank)') }}</p>
                                    <h5 class="mb-0 fw-bold">{{ $atif_bank }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card dashboard-card p-3 h-100">
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div class="dashboard-icon bg-info text-white me-3 flex-shrink-0">
                                    <i class="ti-wallet"></i>
                                </div>
                                <div class="numbers">
                                    <p class="mb-0 text-muted small">{{ _lang('Atif Sahb (Cash)') }}</p>
                                    <h5 class="mb-0 fw-bold">{{ $atif_sahb }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- More Metrics Button -->
                <div class="col-md-12 text-center">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: nowrap; margin-bottom: 10px;">
                        <!-- <button type="button" class="btn btn-primary" onclick="showMoreMetrics()" style="white-space: nowrap;">
                                {{ _lang('View More Metrics') }}
                            </button> -->

                        <div style="width: 150px; display: inline-block;">
                            <select id="class_selector" class="form-control select2"
                                onchange="handleDropdownChange(this)"
                                style="width: 100%; height: 38px;">
                                <option value="none">{{ _lang('Hide All Floors') }}</option>
                                <option value="all" selected>{{ _lang('Show All Rooms') }}</option>
                                @foreach ($total_class as $class)
                                <option value="class-{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Collapsible Sections -->
    @if (count($total_class) > 0)
    <div class="card mb-4" id="floor-details-card" style="display: none;">
        <div class="card-body">
            <div id="floors-container">
                @foreach ($total_class as $class)
                @if(count($class->class_section) > 0)
                <div class="class-content" id="class-{{ $class->id }}">
                    <div class="floor-card-inner">
                        <h4 class="mb-3 pb-2 border-bottom text-primary text-center">{{ $class->class_name }}</h4>
                        @if (count($class->class_section) > 0)
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">{{ _lang('Room') }}</th>
                                    <th class="text-center">{{ _lang('Cap') }}</th>
                                    <th class="text-center">{{ _lang('Vac') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($class->class_section as $section)
                                @php
                                $occupied = section_wise_occupied($section->id);
                                $vacant = $section->capacity - $occupied;
                                $percentage = $section->capacity > 0 ? ($vacant / $section->capacity) * 100 : 0;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $section->section_name }}</td>
                                    <td class="text-center">{{ $section->capacity }}</td>
                                    <td class="text-center 
                                                @if ($percentage <= 0) bg-danger text-white
                                                @elseif($percentage < 25) bg-warning text-dark
                                                @else bg-success text-white @endif">
                                        {{ $vacant }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- @else
                                <div class="alert alert-info p-2 text-center">{{ _lang('No rooms.') }}</div>
                                @endif -->
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

<!--  Charts -->
    <div class="row g-4 mt-3">

        <div class="col-lg-6 col-12">
            <div class="card dashboard-card p-3 h-100">
                <h5 class="text-center mb-3">{{ _lang('Income vs Expense (Total - ') . date('Y') . ')' }}</h5>
                <canvas id="incomeExpensePie" height="250"></canvas>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card dashboard-card p-3" style="height: 500px;">
                <h5 class="text-center mb-3">{{ _lang('Student Status by Month and Year') }}</h5>
                <canvas id="studentStatusBar" height="300"></canvas>
            </div>
        </div>

    </div>
</div>

@endsection

@section('js-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. GLOBAL FUNCTIONS (Must be outside DOMContentLoaded to work with onclick/onchange)

    // function showMoreMetrics() {
    //     Swal.fire({
    //         title: '{{ _lang('
    //         Additional Metrics ') }}',
    //         html: `
    //         <div class="row g-3">
    //             <div class="col-md-6"><div class="card modal-card p-3"><div class="d-flex align-items-center"><div class="modal-icon bg-success text-white me-2"><i class="ti-wallet"></i></div><div class="modal-numbers"><p>{{ _lang('Others Income') }}</p><h5>{{ $currency . ' ' . $monthly_income }}</h5></div></div></div></div>
    //             <div class="col-md-6"><div class="card modal-card p-3"><div class="d-flex align-items-center"><div class="modal-icon bg-danger text-white me-2"><i class="ti-stats-down"></i></div><div class="modal-numbers"><p>{{ _lang('Monthly Expense') }}</p><h5>{{ $currency . ' ' . $monthly_expense }}</h5></div></div></div></div>
    //             <div class="col-md-6"><div class="card modal-card p-3"><div class="d-flex align-items-center"><div class="modal-icon bg-warning text-white me-2"><i class="ti-money"></i></div><div class="modal-numbers"><p>{{ _lang('Cash in Hand') }}</p><h5>{{ $cash_in_hand }}</h5></div></div></div></div>
    //             <div class="col-md-6"><div class="card modal-card p-3"><div class="d-flex align-items-center"><div class="modal-icon bg-primary text-white me-2"><i class="ti-bank"></i></div><div class="modal-numbers"><p>{{ _lang('Atif Sahb (Bank)') }}</p><h5>{{ $atif_bank }}</h5></div></div></div></div>
    //             <div class="col-md-6"><div class="card modal-card p-3"><div class="d-flex align-items-center"><div class="modal-icon bg-info text-white me-2"><i class="ti-wallet"></i></div><div class="modal-numbers"><p>{{ _lang('Atif Sahb (Cash)') }}</p><h5>{{ $atif_sahb }}</h5></div></div></div></div>
    //         </div>`,
    //         width: '800px',
    //         showCancelButton: false,
    //         showConfirmButton: false,
    //         allowOutsideClick: true,
    //         allowEscapeKey: true,
    //         customClass: {
    //             container: 'swal2-container',
    //             popup: 'swal2-popup'
    //         }
    //     });
    // }

    function handleDropdownChange(selectElement) {
        // show all by default
        const selectedValue = selectElement.value || "all";
        const allContentBlocks = document.querySelectorAll(".class-content");
        const container = document.getElementById("floors-container");
        const mainCard = document.getElementById("floor-details-card"); // We grab the card ID

        // Reset: Hide all inner blocks first
        allContentBlocks.forEach(block => {
            block.classList.remove("active");
            block.style.display = "none";
        });

        // 1. If "Select a Floor..." (none) is picked, hide the whole card
        if (selectedValue === "none") {
            mainCard.style.display = "none";
            container.classList.remove("floors-grid-view");
            return; // Stop execution here
        }

        // 2. Otherwise, SHOW the card
        mainCard.style.display = "block";

        if (selectedValue === "all") {
            container.classList.add("floors-grid-view");
            allContentBlocks.forEach(block => {
                block.classList.add("active");
                block.style.display = "block";
            });
        } else {
            container.classList.remove("floors-grid-view");
            const targetBlock = document.getElementById(selectedValue);
            if (targetBlock) {
                targetBlock.classList.add("active");
                targetBlock.style.display = "block";
            }
        }
    }

    // Optional: Keep this if you still have buttons calling it
    function showClassContent(id, btn) {
        document.getElementById('class_selector').value = id;
        const content = document.getElementById(id);
        const isActive = content.classList.contains("active");

        document.querySelectorAll(".class-content").forEach(el => {
            el.classList.remove("active");
            el.style.display = "none";
        });
        document.querySelectorAll(".custom-pill").forEach(b => b.classList.remove("active"));

        if (!isActive) {
            content.classList.add("active");
            content.style.display = "block";
            btn.classList.add("active");
        } else {
            document.getElementById('class_selector').value = "none";
        }
    }

    // 2. DOM LOADED LOGIC (For Charts)
    document.addEventListener("DOMContentLoaded", function() {

        // Helper to safely parse JSON
        function parseJSONSafely(jsonString) {
            try {
                let cleanedString = jsonString.trim();
                cleanedString = cleanedString.replace(/,\s*]$/, ']');
                const parsed = JSON.parse(cleanedString);
                return Array.isArray(parsed) ? parsed.map(Number) : [Number(parsed)];
            } catch (e) {
                console.error('Invalid JSON:', jsonString, 'Error:', e.message);
                return [];
            }
        }

        // --- PIE CHART ---
        try {
            const pieCanvas = document.getElementById('incomeExpensePie');
            if (pieCanvas) {
                const pieCtx = pieCanvas.getContext('2d');
                const incomeData = parseJSONSafely('{{ $yearly_income }}');
                const expenseData = parseJSONSafely('{{ $yearly_expense }}');
                const totalIncome = incomeData.reduce((a, b) => a + b, 0);
                const totalExpense = expenseData.reduce((a, b) => a + b, 0);

                new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['{{ _lang("Income") }}', '{{ _lang("Expense") }}'],
                        datasets: [{
                            data: [totalIncome, totalExpense],
                            backgroundColor: ['#28a745', '#dc3545'],
                            borderColor: ['#ffffff', '#ffffff'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        aspectRatio: 2,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let value = context.raw || 0;
                                        return context.label + ': ' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
        } catch (error) {
            console.error("Pie Chart Failed to Load:", error);
        }

        // --- STUDENT STATUS BAR CHART ---
        try {
            const barCanvas = document.getElementById('studentStatusBar');
            if (barCanvas) {
                const barCtx = barCanvas.getContext('2d');
                const studentData = @json($student_active_report);

                if (!Array.isArray(studentData)) {
                    console.warn('studentData is not an array, skipping chart.');
                } else {
                    const flattenedData = [];
                    studentData.forEach(yearData => {
                        if (yearData.months && Array.isArray(yearData.months)) {
                            yearData.months.forEach(monthData => {
                                flattenedData.push({
                                    year: yearData.year,
                                    month: monthData.month,
                                    status_0_count: monthData.status_0_count,
                                    status_1_count: monthData.status_1_count
                                });
                            });
                        }
                    });

                    flattenedData.sort((a, b) => {
                        if (a.year === b.year) {
                            return a.month - b.month;
                        }
                        return a.year - b.year;
                    });

                    const labels = flattenedData.map(item => {
                        const monthName = new Date(0, item.month - 1).toLocaleString('default', {
                            month: 'short'
                        });
                        return `${monthName} ${item.year}`;
                    });

                    const status0Data = flattenedData.map(item => item.status_0_count);
                    const status1Data = flattenedData.map(item => item.status_1_count);

                    new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: '{{ _lang("Status 0 (Inactive)") }}',
                                    data: status0Data,
                                    backgroundColor: '#36A2EB',
                                    borderColor: '#36A2EB',
                                    borderWidth: 1
                                },
                                {
                                    label: '{{ _lang("Status 1 (Active)") }}',
                                    data: status1Data,
                                    backgroundColor: '#FF6384',
                                    borderColor: '#FF6384',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: '{{ _lang("Number of Students") }}'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: '{{ _lang("Month and Year") }}'
                                    },
                                    ticks: {
                                        autoSkip: false,
                                        maxRotation: 45,
                                        minRotation: 45
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: '{{ _lang("Student Status by Month and Year") }}'
                                }
                            }
                        }
                    });
                }
            }
        } catch (error) {
            console.error("Bar Chart Failed to Load:", error);
        }

        const selector = document.getElementById('class_selector');
        if (selector) {
            handleDropdownChange(selector);
        }
    });
</script>
@endsection