import React from 'react';
import { createStyles, Checkbox, ActionIcon, Avatar, Group, Tooltip, Text } from '@mantine/core';
import { Check, Copy, ExternalLink, Pencil } from 'tabler-icons-react';
import { DateTime } from "luxon";
import { useClipboard } from "@mantine/hooks";
import { IconCheck } from './IconCheck';
import { Link as InertiaLink } from '@inertiajs/inertia-react'

const useStyles = createStyles((theme) => ({
  rowSelected: {
    backgroundColor:
      theme.colorScheme === 'dark'
        ? theme.fn.rgba(theme.colors[theme.primaryColor][7], 0.2)
        : theme.colors[theme.primaryColor][0],
  },
}));

export function LinksTableRow({ item, selected, toggleRow }) {
    const { classes, cx } = useStyles();
    const clipboard = useClipboard();

    return (
      <tr key={item.id} className={cx({ [classes.rowSelected]: selected })}>
        {/* Checkbox */}
        <td onClick={() => toggleRow(item.id)}>
          <Checkbox
            readOnly
            checked={selected}
            transitionDuration={0} />
        </td>
        {/* Edit Action */}
        <td>
          <ActionIcon
            color='blue'
            variant='light'
            size={"sm"}
            component={InertiaLink}
            href={'/app/links/edit/'+item.id}
            target="_blank"
          >
            <Pencil size={16} />
          </ActionIcon>
        </td>
        {/* Avatar */}
        {/* TODO: Update after implementing user authentication */}
        <td><Avatar size={26} radius={26} color="cyan">B</Avatar></td>
        <td>
          <Tooltip label={DateTime.fromISO(item.created_at).toHTTP()}>
            <Text>{DateTime.fromISO(item.created_at).toLocaleString(DateTime.DATE_MED)}</Text>
          </Tooltip>
        </td>
        {/* Short Link and Actions */}
        <td>
          <Group spacing="sm">
            {item.url}

            <Tooltip label={clipboard.copied ? 'Copied' : 'Copy'} color={clipboard.copied ? 'teal' : 'black'}>
              <ActionIcon
                color='teal'
                variant='light'
                size={"sm"}
                component="button"
                onClick={() => {
                  clipboard.copy(item.url);
                }}
              >
                {clipboard.copied ? <Check size={16} /> : <Copy size={16} />}
              </ActionIcon>
            </Tooltip>

            <Tooltip label={'Visit'}>
              <ActionIcon
                color='blue'
                variant='light'
                size={"sm"}
                component="a"
                href={item.url}
                target="_blank"
              >
                <ExternalLink size={16} />
              </ActionIcon>
            </Tooltip>
          </Group>
        </td>
        {/* Redirect Links */}
        <td><IconCheck checked={item.app_url} /></td>
        <td><IconCheck checked={item.android_url} /></td>
        <td><IconCheck checked={item.ios_url} /></td>
        <td><IconCheck checked={item.fallback_url} /></td>
        <td>{item.visits}</td>
      </tr>
    );
}
