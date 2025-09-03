<?php

declare(strict_types = 1);

namespace App\Enums\Models\Permission;

enum Can: string
{
    case PeoplePatientView           = 'people-patient-view';
    case PeoplePatientEdit           = 'people-patient-edit';
    case PeoplePatientBirthdayReport = 'people-patient-birthday-report';
    case PeopleUserView              = 'people-user-view';
    case PeopleUserEdit              = 'people-user-edit';
    case PeopleUserImpersonate       = 'people-user-impersonate';
    case PeopleEmployeeView          = 'people-employee-view';
    case PeopleEmployeeEdit          = 'people-employee-edit';

    case RegistrationRoleView           = 'registration-role-view';
    case RegistrationRoleEdit           = 'registration-role-edit';
    case RegistrationProcedureView      = 'registration-procedure-view';
    case RegistrationProcedureReport    = 'registration-procedure-report';
    case RegistrationProcedureEdit      = 'registration-procedure-edit';
    case RegistrationAgreementsView     = 'registration-agreements-view';
    case RegistrationAgreementsEdit     = 'registration-agreements-edit';
    case RegistrationPaymentMethodsView = 'registration-paymentsMethods-view';
    case RegistrationPaymentMethodsEdit = 'registration-paymentsMethods-edit';
    case RegistrationFrequencyView      = 'registration-frequency-view';
    case RegistrationFrequencyEdit      = 'registration-frequency-edit';
    case RegistrationRemedyView         = 'registration-remedy-view';
    case RegistrationRemedyEdit         = 'registration-remedy-edit';
    case RegistrationRoomView           = 'registration-room-view';
    case RegistrationRoomEdit           = 'registration-room-edit';
    case TriageView                     = 'triage-view';
    case TriageEdit                     = 'triage-edit';
    case RegistrationAnamnesisGroupView = 'registration-anamnesis_group-view';
    case RegistrationAnamnesisGroupEdit = 'registration-anamnesis_group-edit';
    case RegistrationAnamnesisTypeView  = 'registration-anamnesis_type-view';
    case RegistrationAnamnesisTypeEdit  = 'registration-anamnesis_type-edit';
    case TransactionIncomeView          = 'transaction-income-view';
    case TransactionIncomeEdit          = 'transaction-income-edit';

    case TransactionExpenseView       = 'transaction-expense-view';
    case TransactionExpenseEdit       = 'transaction-expense-edit';
    case TransactionCommissionView    = 'transaction-commission-view';
    case TransactionCommissionEdit    = 'transaction-commission-edit';
    case AppointmentAppointmentReport = 'appointment-appointment-report';
    case AppointmentAppointmentView   = 'appointment-appointment-view';
    case AppointmentAppointmentEdit   = 'appointment-appointment-edit';
    case StockLocationView            = 'stock-location-view';
    case StockLocationEdit            = 'stock-location-edit';

    public static function operation(string $label): string
    {
        return match ($label) {
            __('user')            => __('User accounts'),
            __('role')            => __('System roles'),
            __('employee')        => __('Employee records'),
            __('patient')         => __('Patient records'),
            __('frequency')       => __('Frequency records'),
            __('agreements')      => __('Agreements records'),
            __('anamnesis_group') => __('Anamnesis groups records'),
            __('anamnesis_type')  => __('Anamnesis types records'),
            __('paymentsMethods') => __('Payment methods records'),
            __('room')            => __('Rooms records'),
            __('remedy')          => __('Remedies records'),
            __('procedure')       => __('Procedures records'),
            __('appointment')     => __('Appointment records'),
            __('expense')         => __('Income records'),
            __('income')          => __('Expense records'),
            __('commission')      => __('Commission records'),
            __('triage')          => __('Triage records'),
            __('location')        => __('Location records'),
            default               => "operation {$label} do not configured",
        };
    }

    public static function action(string $label): string
    {
        return match ($label) {
            __('view')            => __('can view and list'),
            __('edit')            => __('can create, edit and delete'),
            __('impersonate')     => __('can login as another user'),
            __('birthday report') => __('can view birthday of month and of day'),
            __('report')          => __('can view reports'),
            default               => "action {$label} do not configured",
        };
    }
}
