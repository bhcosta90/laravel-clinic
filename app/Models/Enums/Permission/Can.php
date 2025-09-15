<?php

declare(strict_types = 1);

namespace App\Models\Enums\Permission;

enum Can: string
{
    case PeoplePatientView           = 'people::patient::view';
    case PeoplePatientEdit           = 'people::patient::edit';
    case PeoplePatientBirthdayReport = 'people::patient birthday::report';
    case PeopleUserView              = 'people::user::view';
    case PeopleUserEdit              = 'people::user::edit';
    case PeopleUserImpersonate       = 'people::user::impersonate';
    case PeopleEmployeeView          = 'people::employee::view';
    case PeopleEmployeeEdit          = 'people::employee::edit';

    case RegistrationRoleView           = 'registration::role::view';
    case RegistrationRoleEdit           = 'registration::role::edit';
    case RegistrationProcedureView      = 'registration::procedure::view';
    case RegistrationProcedureReport    = 'registration::procedure::report';
    case RegistrationProcedureEdit      = 'registration::procedure::edit';
    case RegistrationAgreementsView     = 'registration::agreements::view';
    case RegistrationAgreementsEdit     = 'registration::agreements::edit';
    case RegistrationPaymentMethodsView = 'registration::paymentsMethods::view';
    case RegistrationPaymentMethodsEdit = 'registration::paymentsMethods::edit';
    case RegistrationFrequencyView      = 'registration::frequency::view';
    case RegistrationFrequencyEdit      = 'registration::frequency::edit';
    case RegistrationRemedyView         = 'registration::remedy::view';
    case RegistrationRemedyEdit         = 'registration::remedy::edit';
    case RegistrationRoomView           = 'registration::room::view';
    case RegistrationRoomEdit           = 'registration::room::edit';
    case TriageView                     = 'triage::view';
    case TriageEdit                     = 'triage::edit';
    case RegistrationAnamnesisGroupView = 'registration::anamnesis_group::view';
    case RegistrationAnamnesisGroupEdit = 'registration::anamnesis_group::edit';
    case RegistrationAnamnesisTypeView  = 'registration::anamnesis_type::view';
    case RegistrationAnamnesisTypeEdit  = 'registration::anamnesis_type::edit';
    case TransactionIncomeView          = 'transaction::income::view';
    case TransactionIncomeEdit          = 'transaction::income::edit';

    case TransactionExpenseView       = 'transaction::expense::view';
    case TransactionExpenseEdit       = 'transaction::expense::edit';
    case TransactionCommissionView    = 'transaction::commission::view';
    case TransactionCommissionEdit    = 'transaction::commission::edit';
    case AppointmentAppointmentReport = 'appointment::appointment::report';
    case AppointmentAppointmentView   = 'appointment::appointment::view';
    case AppointmentAppointmentEdit   = 'appointment::appointment::edit';
    case StockLocationImportView      = 'stock::location_import::view';
    case StockLocationImportEdit      = 'stock::location_import::edit';
    case StockLocationModuleView      = 'stock::location_module::view';
    case StockLocationModuleEdit      = 'stock::location_module::edit';
    case StockSectorView              = 'stock::sector::view';
    case StockSectorEdit              = 'stock::sector::edit';
    case StockCatalogView             = 'stock::catalog::view';
    case StockCatalogEdit             = 'stock::catalog::edit';

}
