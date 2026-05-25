@if(count($rows))
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Crop</th>
                    <th>Region</th>
                    <th>Mandi</th>
                    <th>Rate</th>
                    <th>Change</th>
                    <th>Source</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td>{{ $row['crop'] }}</td>
                        <td>{{ $row['region'] }}</td>
                        <td>{{ $row['mandi'] }}</td>
                        <td>Rs {{ number_format($row['price'], 2) }} / {{ $row['unit'] }}</td>
                        <td>
                            <span class="pill {{ ($row['change_percent'] ?? 0) >= 0 ? 'blue' : '' }}">
                                {{ ($row['change_percent'] ?? 0) >= 0 ? '+' : '' }}{{ $row['change_percent'] ?? 0 }}%
                            </span>
                        </td>
                        <td>{{ $row['source'] ?? 'Mongo seed' }}</td>
                        <td>{{ $row['updated_at'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty">No mandi price rows found for this region.</div>
@endif
