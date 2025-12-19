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
    </style>

    <div class="container-fluid">

        <!-- Top Row: Cards + Pie Chart -->
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="row g-4">
                    <!-- Student Capacity -->
                    <div class="col-md-6">
                        <div class="card dashboard-card p-3">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-warning text-white me-3">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="numbers">
                                    <p>{{ _lang('Student Capacity') }}</p>
                                    <h4>{{ total_student_capacity() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Occupied Seats -->
                    <div class="col-md-6">
                        <div class="card dashboard-card p-3">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-danger text-white me-3">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="numbers">
                                    <p>{{ _lang('Occupied Seats') }}</p>
                                    <h4>{{ total_student_occupied() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Vacant Seats -->
                    <div class="col-md-6">
                        <div class="card dashboard-card p-3">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-info text-white me-3">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="numbers">
                                    <p>{{ _lang('Vacant Seats') }}</p>
                                    <h4>{{ total_student_vacant() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Monthly Payments -->
                    <div class="col-md-6">
                        <div class="card dashboard-card p-3">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-primary text-white me-3">
                                    <i class="ti-credit-card"></i>
                                </div>
                                <div class="numbers">
                                    <p>{{ _lang('Monthly Payments') }}</p>
                                    <h4>{{ $currency . ' ' . $student_payments }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- More Metrics Button -->
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary" onclick="showMoreMetrics()">
                            {{ _lang('View More Metrics') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-lg-6">
                <div class="card dashboard-card p-3">
                    <h5 class="text-center mb-3">{{ _lang('Income vs Expense (Total - ') . date('Y') . ')' }}</h5>
                    <canvas id="incomeExpensePie" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart for Student Status -->
        <div class="row g-4 mb-4">
            <div class="col-lg-12">
                <div class="card dashboard-card p-3" style="height:500px;">
                    <h5 class="text-center mb-3">{{ _lang('Student Status by Month and Year') }}</h5>
                    <canvas id="studentStatusBar" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Collapsible Sections -->
        @if (count($total_class) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="control-label"><strong>{{ _lang('Filter by Floor') }}</strong></label>
                                <select id="class_selector" class="form-control select2"
                                    onchange="handleDropdownChange(this)">
                                    <option value="none">{{ _lang('Select a Floor...') }}</option>
                                    <option value="all">{{ _lang('Show All Floors') }}</option>
                                    @foreach ($total_class as $class)
                                        <option value="class-{{ $class->id }}">{{ $class->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                      <!--  <div class="col-md-8 text-end">
                            <small class="text-muted">{{ _lang('Or use quick select:') }}</small>
                            <div class="d-flex flex-wrap gap-2 justify-content-end mt-2">
                                @foreach ($total_class as $class)
                                    <button class="btn btn-outline-primary btn-sm custom-pill"
                                        onclick="showClassContent('class-{{ $class->id }}', this)">
                                        {{ $class->class_name }}
                                    </button>
                                @endforeach
                            </div>
                        </div> -->
                    </div>
                </div>

                <div>
                    @foreach ($total_class as $class)
                        <div class="class-content" style="margin-top: 0; padding-top: 0%;" id="class-{{ $class->id }}">
                            <h4 class="mb-3 pb-2 border-bottom text-primary">{{ $class->class_name }}</h4>
                            @if (count($class->class_section) > 0)
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">{{ _lang('Room') }}</th>
                                            <th class="text-center">{{ _lang('Capacity') }}</th>
                                            <th class="text-center">{{ _lang('Vacant') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($class->class_section as $section)
                                            @php
                                                $occupied = section_wise_occupied($section->id);
                                                $vacant = $section->capacity - $occupied;
                                                $percentage =
                                                    $section->capacity > 0 ? ($vacant / $section->capacity) * 100 : 0;
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $section->section_name }}</td>
                                                <td class="text-center">{{ $section->capacity }}</td>
                                                <td
                                                    class="text-center 
                                                        @if ($percentage <= 0) bg-danger text-white
                                                        @elseif($percentage < 25) bg-warning text-dark
                                                        @else bg-success text-white @endif">
                                                    {{ $vacant }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info">{{ _lang('No rooms found for this floor.') }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection

@section('js-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Function to show more metrics in SweetAlert2 modal
        function showMoreMetrics() {
            Swal.fire({
                title: '{{ _lang('Additional Metrics') }}',
                html: `
                    <div class="row g-3">
                        <!-- Others Income -->
                        <div class="col-md-6">
                            <div class="card modal-card p-3">
                                <div class="d-flex align-items-center">
                                    <div class="modal-icon bg-success text-white me-2">
                                        <i class="ti-wallet"></i>
                                    </div>
                                    <div class="modal-numbers">
                                        <p>{{ _lang('Others Income') }}</p>
                                        <h5>{{ $currency . ' ' . $monthly_income }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Expenses -->
                        <div class="col-md-6">
                            <div class="card modal-card p-3">
                                <div class="d-flex align-items-center">
                                    <div class="modal-icon bg-danger text-white me-2">
                                        <i class="ti-stats-down"></i>
                                    </div>
                                    <div class="modal-numbers">
                                        <p>{{ _lang('Monthly Expense') }}</p>
                                        <h5>{{ $currency . ' ' . $monthly_expense }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Cash in Hand -->
                        <div class="col-md-6">
                            <div class="card modal-card p-3">
                                <div class="d-flex align-items-center">
                                    <div class="modal-icon bg-warning text-white me-2">
                                        <i class="ti-money"></i>
                                    </div>
                                    <div class="modal-numbers">
                                        <p>{{ _lang('Cash in Hand') }}</p>
                                        <h5>{{ $cash_in_hand }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Atif Sahb (Bank) -->
                        <div class="col-md-6">
                            <div class="card modal-card p-3">
                                <div class="d-flex align-items-center">
                                    <div class="modal-icon bg-primary text-white me-2">
                                        <i class="ti-bank"></i>
                                    </div>
                                    <div class="modal-numbers">
                                        <p>{{ _lang('Atif Sahb (Bank)') }}</p>
                                        <h5>{{ $atif_bank }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Atif Sahb (Cash) -->
                        <div class="col-md-6">
                            <div class="card modal-card p-3">
                                <div class="d-flex align-items-center">
                                    <div class="modal-icon bg-info text-white me-2">
                                        <i class="ti-wallet"></i>
                                    </div>
                                    <div class="modal-numbers">
                                        <p>{{ _lang('Atif Sahb (Cash)') }}</p>
                                        <h5>{{ $atif_sahb }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                width: '800px',
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                customClass: {
                    container: 'swal2-container',
                    popup: 'swal2-popup'
                }
            });
        }

        function handleDropdownChange(selectElement) {
            const selectedValue = selectElement.value;
            const allContentBlocks = document.querySelectorAll(".class-content");
            const allButtons = document.querySelectorAll(".custom-pill");

            // Reset: Hide all and remove button active states
            allContentBlocks.forEach(block => {
                block.classList.remove("active");
                block.style.display = "none";
            });
            allButtons.forEach(btn => btn.classList.remove("active"));

            if (selectedValue === "all") {
                // Show everything
                allContentBlocks.forEach(block => {
                    block.classList.add("active");
                    block.style.display = "block";
                });
            } else if (selectedValue !== "none") {
                // Show specific floor
                const targetBlock = document.getElementById(selectedValue);
                if (targetBlock) {
                    targetBlock.classList.add("active");
                    targetBlock.style.display = "block";

                    // Optional: sync button highlight if it exists
                    allButtons.forEach(btn => {
                        if (btn.getAttribute('onclick').includes(selectedValue)) {
                            btn.classList.add("active");
                        }
                    });
                }
            }
        }

        // 2. Handle the Button logic (stays for convenience)
        function showClassContent(id, btn) {
            // Sync the dropdown value
            document.getElementById('class_selector').value = id;

            const content = document.getElementById(id);
            const isActive = content.classList.contains("active");

            // Hide everything first
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

        document.addEventListener("DOMContentLoaded", function() {
            // Parse JSON safely function
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

            // Income vs Expense Pie Chart
            const pieCtx = document.getElementById('incomeExpensePie').getContext('2d');
            const incomeData = parseJSONSafely('{{ $yearly_income }}');
            const expenseData = parseJSONSafely('{{ $yearly_expense }}');
            const totalIncome = incomeData.reduce((a, b) => a + b, 0);
            const totalExpense = expenseData.reduce((a, b) => a + b, 0);

            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['{{ _lang('Income') }}', '{{ _lang('Expense') }}'],
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

            // Student Status Bar Chart
            const barCtx = document.getElementById('studentStatusBar').getContext('2d');
            const studentData = @json($student_active_report);

            // Check if studentData is valid
            if (!Array.isArray(studentData)) {
                console.error('studentData is not an array:', studentData);
                throw new Error('Invalid student data format');
            }

            // Flatten the data to create an array of month-year entries
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

            // Sort by year and month to ensure chronological order
            flattenedData.sort((a, b) => {
                if (a.year === b.year) {
                    return a.month - b.month;
                }
                return a.year - b.year;
            });

            // Create labels (e.g., "Jan 2023", "Feb 2023", etc.)
            const labels = flattenedData.map(item => {
                const monthName = new Date(0, item.month - 1).toLocaleString('default', {
                    month: 'short'
                });
                return `${monthName} ${item.year}`;
            });

            // Create datasets for status 0 and status 1
            const status0Data = flattenedData.map(item => item.status_0_count);
            const status1Data = flattenedData.map(item => item.status_1_count);

            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: '{{ _lang('Status 0 (Inactive)') }}',
                            data: status0Data,
                            backgroundColor: '#36A2EB',
                            borderColor: '#36A2EB',
                            borderWidth: 1
                        },
                        {
                            label: '{{ _lang('Status 1 (Active)') }}',
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
                                text: '{{ _lang('Number of Students') }}'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: '{{ _lang('Month and Year') }}'
                            },
                            ticks: {
                                autoSkip: false, // Ensure all labels are shown
                                maxRotation: 45, // Rotate labels for better readability
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
                            text: '{{ _lang('Student Status by Month and Year') }}'
                        }
                    }
                }
            });


        });
    </script>
@endsection
