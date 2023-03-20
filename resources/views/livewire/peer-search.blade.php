<div style="display: flex; flex-direction: column; row-gap: 1rem;">
    <section class="panelV2">
        <header class="panel__header">
            <h2 class="panel__heading">{{ __('common.search') }}</h2>
        </header>
        <div class="panel__body" style="padding: 5px;">
            <form class="form">
                <div class="form__group--short-horizontal">
                    <p class="form__group">
                        <input wire:model="torrent" class="form__text" placeholder="">
                        <label class="form__label form__label--floating">Torrent Name</label>
                    </p>
                    <p class="form__group">
                        <input wire:model="ip" class="form__text" placeholder="">
                        <label class="form__label form__label--floating">IP Address</label>
                    </p>
                    <p class="form__group">
                        <input wire:model="port" class="form__text" placeholder="">
                        <label class="form__label form__label--floating">Port</label>
                    </p>
                    <p class="form__group">
                        <input wire:model="agent" class="form__text" placeholder="">
                        <label class="form__label form__label--floating">Agent</label>
                    </p>
                    <p class="form__group">
                        <select wire:model="connectivity" class="form__select" placeholder="">
                            <option value="any">Any</option>
                            <option value="connectable">Connectable</option>
                            <option value="unconnectable">Unconnectable</option>
                        </select>
                        <label class="form__label form__label--floating">Connectivity</label>
                    </p>
                    <p class="form__group">
                        <select wire:model="groupBy" class="form__select" placeholder="">
                            <option value="none">None</option>
                            <option value="user_session">User Session</option>
                            <option value="user_ip">User IP</option>
                            <option value="user">User</option>
                        </select>
                        <label class="form__label form__label--floating">Group By</label>
                    </p>
                    <p class="form__group">
                        <label class="form__label">
                            <input wire:model="duplicateIpsOnly" type="checkbox" class="form__checkbox">
                            Duplicate Ips Only
                        </label>
                    </p>
                    <p class="form__group">
                        <label class="form__label">
                            <input wire:model="includeSeedsize" type="checkbox" class="form__checkbox">
                            Include Seedsize
                        </label>
                    </p>
                </div>
            </form>
        </div>
    </section>
    <section class="panelV2">
        <h2 class="panel__heading">Peers</h2>
        <div class="data-table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th wire:click="sortBy('peers.user_id')" role="columnheader button">
                            {{ __('user.user') }}
                            @include('livewire.includes._sort-icon', ['field' => 'peers.user_id'])
                        </th>
                        @if ($groupBy !== 'none')
                            <th wire:click="sortBy('peer_count')" role="columnheader button" style="text-align: right">
                                {{ __('torrent.peers') }}
                                @include('livewire.includes._sort-icon', ['field' => 'peer_count'])
                            </th>
                        @endif
                        <th wire:click="sortBy('torrent_id')" role="columnheader button">
                            @if ($groupBy === 'none')
                                {{ __('torrent.torrent') }}
                            @else
                                {{ __('torrent.torrents') }}
                                @include('livewire.includes._sort-icon', ['field' => 'torrent_id'])
                            @endif
                        </th>
                        <th wire:click="sortBy('agent')" role="columnheader button">
                            @if ($groupBy === 'user_ip' || $groupBy === 'user')
                                Agents
                            @else
                                {{ __('torrent.agent') }}
                            @endif
                            @include('livewire.includes._sort-icon', ['field' => 'agent'])
                        </th>
                        <th wire:click="sortBy('ip')" role="columnheader button" style="text-align: right">
                            @if ($groupBy === 'none' || $groupBy === 'user_ip' || $groupBy === 'user_session')
                                IP
                            @else
                                IPs
                            @endif
                            @include('livewire.includes._sort-icon', ['field' => 'ip'])
                        </th>
                        <th wire:click="sortBy('port')" role="columnheader button" style="text-align: right">
                            @if ($groupBy === 'user_ip' || $groupBy === 'user')
                                Ports
                            @else
                                Port
                            @endif
                            @include('livewire.includes._sort-icon', ['field' => 'port'])
                        </th>
                        <th wire:click="sortBy('uploaded')" role="columnheader button" style="text-align: right">
                            {{ __('torrent.uploaded') }}
                            @include('livewire.includes._sort-icon', ['field' => 'uploaded'])
                        </th>
                        <th wire:click="sortBy('downloaded')" role="columnheader button" style="text-align: right">
                            {{ __('torrent.downloaded') }}
                            @include('livewire.includes._sort-icon', ['field' => 'downloaded'])
                        </th>
                        <th wire:click="sortBy('left')" role="columnheader button" style="text-align: right">
                            {{ __('torrent.left') }}
                            @include('livewire.includes._sort-icon', ['field' => 'left'])
                        </th>
                        @if ($groupBy === 'none')
                            @if ($includeSeedsize)
                                <th wire:click="sortBy('size')" wire:key="size" role="columnheader button" style="text-align: right">
                                    {{ __('torrent.size') }}
                                    @include('livewire.includes._sort-icon', ['field' => 'size'])
                                </th>
                            @else
                                <th style="text-align: right">{{ __('torrent.size') }}</th>
                            @endif
                        @else
                            @if ($includeSeedsize)
                                <th wire:click="sortBy('size')" role="columnheader button" style="text-align: right">
                                    {{ __('torrent.size') }}
                                    @include('livewire.includes._sort-icon', ['field' => 'size'])
                                </th>
                                @if (\config('announce.connectable_check'))
                                    <th wire:click="sortBy('connectable_size')" role="columnheader button" style="text-align: right">
                                        Connectable {{ __('torrent.size') }}
                                        @include('livewire.includes._sort-icon', ['field' => 'connectable_size'])
                                    </th>
                                    <th wire:click="sortBy('unconnectable_size')" role="columnheader button" style="text-align: right">
                                        Unconnectable {{ __('torrent.size') }}
                                        @include('livewire.includes._sort-icon', ['field' => 'unconnectable_size'])
                                    </th>
                                @endif
                            @endif
                        @endif
                        @if (\config('announce.connectable_check'))
                            @if ($groupBy === 'none')
                                <th wire:click="sortBy('connectable')" role="columnheader button" style="text-align: right">
                                    Connectable
                                    @include('livewire.includes._sort-icon', ['field' => 'connectable'])
                                </th>
                            @else
                                <th wire:click="sortBy('connectable_count')" role="columnheader button" style="text-align: right">
                                    Connectable {{ __('torrent.peers') }}
                                    @include('livewire.includes._sort-icon', ['field' => 'connectable_count'])
                                </th>
                                <th wire:click="sortBy('unconnectable_count')" role="columnheader button" style="text-align: right">
                                    Unconnectable {{ __('torrent.peers') }}
                                    @include('livewire.includes._sort-icon', ['field' => 'unconnectable_count'])
                                </th>
                            @endif
                        @endif
                        <th wire:click="sortBy('created_at')" role="columnheader button" style="text-align: right">
                            Started
                            @include('livewire.includes._sort-icon', ['field' => 'created_at'])
                        </th>
                        <th wire:click="sortBy('updated_at')" role="columnheader button" style="text-align: right">
                            Announced
                            @include('livewire.includes._sort-icon', ['field' => 'updated_at'])
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peers as $peer)
                        <tr>
                            <td>
                                <x-user_tag :user="$peer->user" :anon="false" />
                            </td>
                            @if ($groupBy !== 'none')
                                <td style="text-align: right">
                                    {{ $peer->peer_count }}
                                </td>
                            @endif
                            @if ($groupBy === 'none')
                                <td>
                                    <a href="{{ route('torrent', ['id' => $peer->torrent_id]) }}">
                                        {{ $peer->torrent->name ?? '' }}
                                    </a>
                                </td>
                            @else
                                <td style="text-align: right">
                                    {{ $peer->torrent_id }}
                                </td>
                            @endif
                            @if ($groupBy === 'none' || $groupBy === 'user_session')
                                <td>{{ $peer->agent }}</td>
                            @else
                                <td style="text-align: right">
                                    {{ $peer->agent }}
                                </td>
                            @endif
                            <td style="text-align: right">
                                {{ $peer->ip }}
                            </td>
                            <td style="text-align: right">
                                {{ $peer->port }}
                            </td>
                            <td style="text-align: right">
                                {{ App\Helpers\StringHelper::formatBytes($peer->uploaded, 2) }}
                            </td>
                            <td style="text-align: right">
                                {{ App\Helpers\StringHelper::formatBytes($peer->downloaded, 2) }}
                            </td>
                            <td style="text-align: right">
                                {{ App\Helpers\StringHelper::formatBytes($peer->left, 2) }}
                            </td>
                            @if ($groupBy === 'none')
                                <td style="text-align: right">
                                    {{ App\Helpers\StringHelper::formatBytes($peer->torrent->size ?? 0) }}
                                </td>
                            @else
                                @if ($includeSeedsize)
                                    <td style="text-align: right">
                                        {{ App\Helpers\StringHelper::formatBytes($peer->size ?? 0) }}
                                    </td>
                                    @if (\config('announce.connectable_check'))
                                        <td style="text-align: right">
                                            {{ App\Helpers\StringHelper::formatBytes($peer->connectable_size ?? 0) }}
                                        </td>
                                        <td style="text-align: right">
                                            {{ App\Helpers\StringHelper::formatBytes($peer->unconnectable_size ?? 0) }}
                                        </td>
                                    @endif
                                @endif
                            @endif
                            @if (\config('announce.connectable_check'))
                                @if ($groupBy === 'none')
                                    <td style="text-align: right">
                                        @if ($peer->connectable)
                                            <i class="{{ config('other.font-awesome') }} text-green fa-check" title="Connectable"></i>
                                        @else
                                            <i class="{{ config('other.font-awesome') }} text-red fa-times" title="Not Connectable"></i>
                                        @endif
                                    </td>
                                @else
                                    <td style="text-align: right">{{ $peer->connectable_count }}</td>
                                    <td style="text-align: right">{{ $peer->unconnectable_count }}</td>
                                @endif
                            @endif
                            <td style="text-align: right">{{ $peer->created_at?->diffForHumans() ?? 'N/A' }}</td>
                            <td style="text-align: right">{{ $peer->updated_at?->diffForHumans() ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $peers->links('partials.pagination') }}
        </div>
    </section>
</div>