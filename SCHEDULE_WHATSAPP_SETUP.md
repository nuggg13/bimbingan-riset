# Enhanced Schedule System with WhatsApp Integration

## Database Updates Required

### 1. Run Database Migration
Execute the following commands in your terminal:

```bash
# Run the migration to add 'hari' column
php artisan migrate

# Or manually run the SQL script
# Import database_update.sql into your MySQL database
```

### 2. Update Composer Autoload
Run this command to update the autoloader for the WhatsApp helper:

```bash
composer dump-autoload
```

## New Features Implemented

### 1. **Enhanced Schedule System**
- **Weekly Recurring Schedules**: Schedules can now be set for specific days of the week
- **Day Format**: Store days as comma-separated values (e.g., "senin,rabu,jumat")
- **Smart Display**: Shows "Setiap Senin dan Rabu, 09:00 - 11:00" instead of specific dates
- **Flexible Scheduling**: Supports both one-time and recurring schedules

### 2. **WhatsApp Integration**
- **Direct WhatsApp Links**: All mentor contact buttons now open WhatsApp directly
- **Pre-filled Messages**: Contextual messages based on the action (contact mentor vs schedule discussion)
- **Phone Number Formatting**: Automatic conversion to proper WhatsApp format (+62)
- **Smart Message Generation**: Different messages for different scenarios

### 3. **Enhanced Dashboard Features**
- **Mentor Information**: Complete mentor details with direct WhatsApp contact
- **Schedule Status**: Visual indicators for different schedule statuses
- **Quick Actions**: WhatsApp-enabled buttons for immediate communication
- **Schedule History**: Shows both one-time and recurring schedules with proper formatting

## Database Schema Changes

### New Column in `jadwal` table:
```sql
`hari` VARCHAR(255) NULL COMMENT 'Hari dalam seminggu (senin,rabu,jumat)'
```

### Example Data:
```sql
-- Recurring schedule: Every Monday and Wednesday, 9:00-11:00
INSERT INTO jadwal (id_pendaftaran, id_mentor, tanggal_mulai, tanggal_akhir, jam_mulai, jam_akhir, hari, status) 
VALUES (1, 1, '2025-01-13', '2025-03-31', '09:00:00', '11:00:00', 'senin,rabu', 'scheduled');
```

## WhatsApp Message Templates

### 1. **Contact Mentor Message**:
```
Halo, saya [Nama Peserta], peserta bimbingan riset dengan judul "[Judul Riset]". Saya ingin berkonsultasi mengenai riset saya. Terima kasih.
```

### 2. **Schedule Discussion Message**:
```
Halo, saya [Nama Peserta], peserta bimbingan riset dengan judul "[Judul Riset]". Saya ingin mendiskusikan jadwal bimbingan yang saat ini terjadwal pada [Jadwal]. Apakah bisa diatur ulang? Terima kasih.
```

## Usage Examples

### 1. **Setting Up Recurring Schedule**:
```php
Jadwal::create([
    'id_pendaftaran' => 1,
    'id_mentor' => 1,
    'tanggal_mulai' => '2025-01-13',
    'tanggal_akhir' => '2025-03-31',
    'jam_mulai' => '09:00:00',
    'jam_akhir' => '11:00:00',
    'hari' => 'senin,rabu',  // Monday and Wednesday
    'status' => 'scheduled'
]);
```

### 2. **Generating WhatsApp URL**:
```php
$whatsappUrl = WhatsAppHelper::generateWhatsAppUrl(
    $mentor->nomor_wa, 
    WhatsAppHelper::generateMentorContactMessage($peserta->nama, $pendaftaran->judul_riset)
);
```

### 3. **Displaying Schedule**:
```php
// For recurring schedule: "Setiap Senin dan Rabu, 09:00 - 11:00"
echo $jadwal->schedule_description;

// For one-time schedule: "13 Jan 2025, 09:00 - 11:00"
echo $jadwal->formatted_date_time;
```

## Testing the Features

### 1. **Test WhatsApp Integration**:
- Ensure mentor has valid WhatsApp number in +62 format
- Click "Hubungi Mentor" button - should open WhatsApp with pre-filled message
- Click "Diskusi Jadwal" button - should open WhatsApp with schedule-specific message

### 2. **Test Schedule Display**:
- Create schedule with `hari` field: "senin,rabu"
- Dashboard should show "Setiap Senin dan Rabu, [time]"
- Schedule history should show recurring schedule format

### 3. **Test Status-Based Actions**:
- When mentor is not assigned: buttons should be disabled
- When mentor is assigned: buttons should be active WhatsApp links
- Different messages for different scenarios

## Troubleshooting

### 1. **WhatsApp Links Not Working**:
- Check phone number format in database (+62 format)
- Verify WhatsAppHelper is properly autoloaded
- Check browser console for JavaScript errors

### 2. **Schedule Display Issues**:
- Verify `hari` column exists in database
- Check if migration was run successfully
- Ensure proper data format in `hari` field

### 3. **Missing Mentor Information**:
- Check if mentor data exists in database
- Verify relationships between jadwal, pendaftaran, and mentor
- Ensure proper foreign key constraints

## Security Considerations

1. **Phone Number Validation**: All phone numbers are validated and formatted
2. **Message Sanitization**: All messages are URL-encoded for safety
3. **CSRF Protection**: All forms maintain CSRF protection
4. **Input Validation**: All user inputs are validated before processing

## Future Enhancements

1. **Schedule Conflict Detection**: Prevent overlapping schedules
2. **Automated Reminders**: WhatsApp reminders before scheduled sessions
3. **Calendar Integration**: Export schedules to calendar applications
4. **Mentor Availability**: Real-time mentor availability checking