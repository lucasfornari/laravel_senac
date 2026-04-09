{{-- resources/views/ticket.blade.php --}}

<main style="max-width: 1200px; margin: 2rem auto; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; padding: 0 1rem;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin: 0; color: #1a202c;">Tickets</h1>
        <p style="color: #718096; margin-top: 0.5rem;">Gerenciar e acompanhar tickets</p>
    </div>

    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <tr>
                        <th style="padding: 16px; text-align: left; font-weight: 600; font-size: 0.95rem;">ID</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; font-size: 0.95rem;">Título</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; font-size: 0.95rem;">Descrição</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; font-size: 0.95rem;">Status</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; font-size: 0.95rem;">Criado Em</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; font-size: 0.95rem;">Atualizado Em</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr style="border-bottom: 1px solid #e2e8f0; transition: background-color 0.2s; background-color: #f7fafc;">
                        <td style="padding: 14px 16px; color: #667eea; font-weight: 600;">#{{ $ticket->id }}</td>
                        <td style="padding: 14px 16px; color: #2d3748; font-weight: 500;">{{ $ticket->title }}</td>
                        <td style="padding: 14px 16px; color: #4a5568; font-size: 0.95rem; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $ticket->description }}</td>
                        <td style="padding: 14px 16px;">
                            <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background-color:#f7fafc; color: #2d3748;">{{ $ticket->status }}</span>
                        </td>
                        <td style="padding: 14px 16px; color: #718096; font-size: 0.95rem;">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        <td style="padding: 14px 16px; color: #718096; font-size: 0.95rem;">{{ $ticket->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 40px 16px; text-align: center; color: #a0aec0;">
                            <div style="font-size: 1rem;">📋 Nenhum ticket encontrado.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 2rem; text-align: center;">
        {{-- Adicione paginação aqui se necessário --}}
    </div>
</main>