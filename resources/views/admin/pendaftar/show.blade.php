<div class="detail-container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <h4 style="margin-top: 0; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Informasi Pendaftar</h4>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; color: var(--muted); width: 120px;">Nama</td>
                    <td style="padding: 8px 0; font-weight: 600;">: {{ $pendaftar->nama }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: var(--muted);">Jenjang</td>
                    <td style="padding: 8px 0;">: {{ $pendaftar->jenjang }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: var(--muted);">Email</td>
                    <td style="padding: 8px 0;">: {{ $pendaftar->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: var(--muted);">WhatsApp</td>
                    <td style="padding: 8px 0;">: {{ $pendaftar->wa }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: var(--muted);">Tgl Daftar</td>
                    <td style="padding: 8px 0;">: {{ $pendaftar->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: var(--muted);">Status Saat Ini</td>
                    <td style="padding: 8px 0;">
                        <span class="badge {{ $pendaftar->status == 'pending' ? 'warning' : ($pendaftar->status == 'diterima' ? 'success' : 'danger') }}" 
                              style="padding: 4px 8px; border-radius: 4px; font-size: 12px; background: rgba(var(--bg-rgb), 0.1); border: 1px solid currentColor;">
                            {{ ucfirst($pendaftar->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        
        <div>
            <h4 style="margin-top: 0; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Tindakan</h4>
            
            <form id="form-update-status" action="{{ route('admin.pendaftar.update', $pendaftar->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 15px;">
                    <label for="status" style="display:block; margin-bottom:8px; font-size: 13px; color: var(--muted);">Update Status Pendaftaran</label>
                    <select name="status" id="status" class="form-control" style="width:100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                        <option value="pending" {{ $pendaftar->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ $pendaftar->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $pendaftar->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn primary" style="width: 100%; justify-content: center;">Simpan Perubahan</button>
            </form>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid var(--border);">
                <button type="button" class="btn danger" id="btn-delete" data-url="{{ route('admin.pendaftar.destroy', $pendaftar->id) }}" style="width: 100%; justify-content: center;">
                    Hapus Data Pendaftar
                </button>
            </div>
        </div>
    </div>
</div>
